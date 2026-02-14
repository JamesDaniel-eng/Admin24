<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferOrderItem extends Model
{
    use Cloneable, HasFactory;

    protected $table = 'inventory_transfer_order_items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'transfer_order_id', 'item_id', 'item_quantity', 'transfer_quantity', 'purchase_price', 'total_amt', 'created_from', 'created_by', 'created_at'];

    /**
     * Attributes that should be visible when serializing the model.
     *
     * @var array
     */
    protected $visible = ['id', 'company_id', 'transfer_order_id', 'item_id', 'item_quantity', 'transfer_quantity', 'purchase_price', 'total_amt', 'created_from', 'created_by', 'created_at', 'updated_at', 'deleted_at', 'item', 'transfer_order'];

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item')->withDefault(['name' => trans('general.na')]);
    }

    public function transfer_order()
    {
        return $this->belongsTo('Modules\Inventory\Models\TransferOrder');
    }
}
