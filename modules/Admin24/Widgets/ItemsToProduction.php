<?php

namespace Modules\Admin24\Widgets;

use App\Abstracts\Widget;
use Modules\Inventory\Models\InventoryItems;
use Modules\Inventory\Models\TransferOrders;

class ItemsToProduction extends Widget
{
    public $default_name = 'admin24::widgets.to_production';

    public $description = 'my-admin24::widgets.description.to_production';

    public $report_class = 'Modules\Admin24\Reports\ItemsToProduction';

    public function show()
    {
        $query = TransferOrders::withCount('items')->enabled()->orderBy('date', 'desc');

        $this->applyFilters($query, ['date_field' => 'created_at'])->each(function ($transfer) {
            $random_color = '#' . dechex(rand(0x000000, 0xFFFFFF));

            $this->addToDonut($random_color, $transfer->name, $transfer->items);
        });

        $chart = $this->getDonutChart(trans('admin24::widgets.to_production'), 0, 160, 6);

        return $this->view('widgets.donut_chart', [
            'chart' => $chart,
        ]);
    }
}