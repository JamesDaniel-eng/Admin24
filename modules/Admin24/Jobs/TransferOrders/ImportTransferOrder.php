<?php

namespace Modules\Inventory\Jobs\TransferOrders;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\Admin24\Models\TransferOrder;
use Modules\Inventory\Events\TransferOrderCreated;

class ImportTransferOrder extends Job implements HasOwner, HasSource, ShouldCreate
{
    public function handle(): TransferOrder
    {
        \DB::transaction(function () {
            $this->request->merge(['status' => 'draft']);

            $this->model = TransferOrder::create($this->request->all());

            

            $this->dispatch(new CreateTransferOrderHistory($this->model));

            event(new TransferOrderCreated($this->model));
        });

        return $this->model;
    }
}
