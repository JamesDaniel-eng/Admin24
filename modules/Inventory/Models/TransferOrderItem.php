<?php

namespace Modules\Inventory\Models;

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
    protected $fillable = ['company_id', 'transfer_order_id', 'item_id', 'item_quantity', 'transfer_quantity', 'purchase_price', 'total_amt', 'created_from', 'created_by'];

    /**
     * Attributes that should be visible when serializing the model.
     *
     * @var array
     */
    protected $visible = ['id', 'company_id', 'transfer_order_id', 'item_id', 'item_quantity', 'transfer_quantity', 'purchase_price', 'total_amt', 'created_from', 'created_by', 'created_at', 'updated_at', 'deleted_at', 'item', 'transfer_order', 'calculated_purchase_price', 'calculated_total_amt'];

    /**
     * Append calculated attributes to JSON
     */
    protected $appends = ['calculated_purchase_price', 'calculated_total_amt'];

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item')->withDefault(['name' => trans('general.na')]);
    }

    public function transfer_order()
    {
        return $this->belongsTo('Modules\Inventory\Models\TransferOrder');
    }

    /**
     * Get purchase price from item, with fallback to stored purchase_price
     */
    public function getCalculatedPurchasePriceAttribute()
    {
        if($this->item && $this->item->purchase_price !== null){
            return $this->item->purchase_price;
        }
        return $this->attributes['purchase_price'] ?? null;
    }

    /**
     * Get total amount (purchase_price * transfer_quantity)
     */
    public function getCalculatedTotalAmtAttribute()
    {
        $price = $this->calculated_purchase_price;
        if($price !== null){
            return $price * ($this->transfer_quantity ?? 0);
        }
        return $this->attributes['total_amt'] ?? null;
    }
}

