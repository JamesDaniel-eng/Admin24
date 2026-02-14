<?php

namespace Modules\DoubleEntry\Imports\JournalEntry\Sheets;

use App\Abstracts\Import;
use Modules\DoubleEntry\Http\Requests\Account as Request;
use Modules\DoubleEntry\Models\Account as Model;
use Modules\DoubleEntry\Traits\Accounts;

class ChartOfAccounts extends Import
{
    use Accounts;

    public $model = Model::class;

    public $columns = [
        'code',
    ];

    public function model(array $row)
    {
        if (! $row ) {
            return;
        }
        
        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $row['type_id'] = $this->findImportedTypeId($row);

        if (is_null($row['type_id'])) {
            return [];
        }

        $row['account_id'] = $this->findImportedAccountId($row['parent']);

        return parent::map($row);
    }

    public function rules(): array
    {
        $rules = (new Request())->rules();

        $rules['code'] = 'required|integer';

        return $rules;
    }
}
