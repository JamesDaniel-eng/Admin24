<?php

namespace Modules\Inventory\Exports\Show\Warehouses;

use Modules\Inventory\Exports\Show\Warehouses\Sheets\Stock;
use Modules\Inventory\Exports\Show\Warehouses\Sheets\Histories;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Show implements WithMultipleSheets
{
    use Exportable;

    public $ids;

    public function __construct()
    {
        $this->ids = request()->segment(4);
    }

    public function sheets(): array
    {
        return [
            new Stock($this->ids),
            new Histories($this->ids),
        ];
    }
}
