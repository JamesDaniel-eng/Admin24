<?php

namespace Modules\DoubleEntry\Exports\JournalEntry\Sheets;

use App\Abstracts\Export;
use Modules\DoubleEntry\Models\Ledger;
use App\Models\Banking\Transaction as Model;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Http\Requests\Banking\Transaction as Request;

class Transactions extends Export implements WithColumnFormatting
{
    public $request_class = Request::class;

    public function collection()
    {
        $transaction_ids = Ledger::where('ledgerable_type', 'Modules\DoubleEntry\Models\Journal');

        if ($this->ids) {
            $transaction_ids = $transaction_ids->whereIn('ledgerable_id', $this->ids);
        }

        $transaction_ids = $transaction_ids->pluck('transaction_id')->toArray();

        return Model::whereIn('id', $transaction_ids)
            ->with('account', 'category', 'contact', 'document')
            ->cursor();
    }

    public function map($model): array
    {
        $model->account_name = $model->account->name;
        $model->contact_email = $model->contact->email;
        $model->category_name = $model->category->name;
        $model->invoice_bill_number = $model->document->document_number ?? 0;
        $model->parent_number = Model::isRecurring()->find($model->parent_id)?->number;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'type',
            'number',
            'paid_at',
            'amount',
            'currency_code',
            'currency_rate',
            'account_name',
            'invoice_bill_number',
            'contact_email',
            'category_name',
            'description',
            'payment_method',
            'reference',
            'reconciled',
            'parent_number',
        ];
    }

    public function columnValidations(): array
    {
        return [
            'type' => [
                'options' => array_keys(config('type.transaction'))
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
