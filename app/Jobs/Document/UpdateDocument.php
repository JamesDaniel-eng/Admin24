<?php

namespace App\Jobs\Document;

use App\Abstracts\Job;
use App\Events\Document\PaidAmountCalculated;
use App\Events\Document\DocumentUpdated;
use App\Events\Document\DocumentUpdating;
use App\Interfaces\Job\ShouldUpdate;
use App\Jobs\Document\CreateDocumentItemsAndTotals;
use App\Models\Document\Document;
use App\Traits\Relationships;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UpdateDocument extends Job implements ShouldUpdate
{
    use Relationships;

    public function handle(): Document
    {
        Log::info('UpdateDocument Job Started', [
            'document_id' => $this->model->id,
            'document_type' => $this->model->type,
            'request_keys' => array_keys($this->request->all()),
            'items_count' => count($this->request->get('items', [])),
            'has_issued_at' => isset($this->request['issued_at']),
            'has_due_at' => isset($this->request['due_at']),
            'has_currency_code' => isset($this->request['currency_code']),
            'issued_at' => $this->request->get('issued_at'),
            'due_at' => $this->request->get('due_at'),
            'currency_code' => $this->request->get('currency_code'),
        ]);

        if (empty($this->request['amount'])) {
            $this->request['amount'] = 0;
        }

        // Disable this lines for global discount issue fixed ( https://github.com/akaunting/akaunting/issues/2797 )
        if (! empty($this->request['discount'])) {
            $this->request['discount_rate'] = $this->request['discount'];
        }

        event(new DocumentUpdating($this->model, $this->request));

        \DB::transaction(function () {
            Log::info('UpdateDocument Transaction Started', [
                'document_id' => $this->model->id,
            ]);

            // Upload attachment
            if ($this->request->file('attachment')) {
                Log::info('Deleting old attachments');
                $this->deleteMediaModel($this->model, 'attachment', $this->request);

                foreach ($this->request->file('attachment') as $attachment) {
                    Log::info('Processing attachment', ['name' => $attachment->getClientOriginalName()]);
                    $media = $this->getMedia($attachment, Str::plural($this->model->type));

                    $this->model->attachMedia($media, 'attachment');
                }
            } elseif (! $this->request->file('attachment') && $this->model->attachment) {
                Log::info('Deleting existing attachment');
                $this->deleteMediaModel($this->model, 'attachment', $this->request);
            }

            Log::info('Deleting old relationships', [
                'relationships' => ['items', 'item_taxes', 'totals']
            ]);
            $this->deleteRelationships($this->model, ['items', 'item_taxes', 'totals'], true);

            Log::info('Creating document items and totals', [
                'items_count' => count($this->request->get('items', []))
            ]);
            $this->dispatch(new CreateDocumentItemsAndTotals($this->model, $this->request));

            $this->model->paid_amount = $this->model->paid;
            Log::info('Paid amount calculated', [
                'paid_amount' => $this->model->paid_amount,
                'request_amount' => $this->request->get('amount')
            ]);

            event(new PaidAmountCalculated($this->model));

            if ($this->model->paid_amount > 0) {
                if ($this->request['amount'] == $this->model->paid_amount) {
                    $this->request['status'] = 'paid';
                    Log::info('Status set to paid');
                }

                if ($this->request['amount'] > $this->model->paid_amount) {
                    $this->request['status'] = 'partial';
                    Log::info('Status set to partial');
                }
            }

            unset($this->model->reconciled);
            unset($this->model->paid_amount);

            Log::info('Updating model with request data', [
                'updated_keys' => array_keys($this->request->all()),
            ]);
            $this->model->update($this->request->all());

            Log::info('Updating recurring document');
            $this->model->updateRecurring($this->request->all());

            Log::info('UpdateDocument Transaction Completed', [
                'document_id' => $this->model->id,
            ]);
        });

        event(new DocumentUpdated($this->model, $this->request));

        Log::info('UpdateDocument Job Completed Successfully', [
            'document_id' => $this->model->id,
            'document_status' => $this->model->status,
        ]);

        return $this->model;
    }
}
