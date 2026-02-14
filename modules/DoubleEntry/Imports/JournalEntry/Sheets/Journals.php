<?php

namespace Modules\DoubleEntry\Imports\JournalEntry\Sheets;

use App\Abstracts\Import;
use App\Models\Setting\Currency;
use Modules\DoubleEntry\Http\Requests\Journal as Request;
use Modules\DoubleEntry\Models\Journal;
use Modules\DoubleEntry\Models\Journal as Model;

class Journals extends Import
{
    public $model = Model::class;

    public $columns = [
        'journal_number',
    ];

    public function model(array $row)
    {
        if (! $row) {
            return;
        }
        
        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        if ($this->isEmpty($row, 'number')) {
            return [];
        }

        $row['basis'] = strtolower($row['basis']);

        if (!array_key_exists($row['basis'], Journal::BASIS)) {
            return [];
        }

        $row = parent::map($row);

        $row['currency_code'] = $this->getCurrencyCode($row);

        $currency = Currency::code($row['currency_code'])->first();

        if (!isset($row['currency_rate'])) {
            $row['currency_rate'] = $currency->rate;
        }

        $row['journal_number'] = $row['number'];
        $row['paid_at'] = $row['issued_at'];

        return $row;
    }

    public function rules(): array
    {
        $rules = (new Request())->rules();

        unset($rules['items'], $rules['items.*.account_id'], $rules['items.*.debit'], $rules['items.*.credit']);

        return $rules;
    }
}
