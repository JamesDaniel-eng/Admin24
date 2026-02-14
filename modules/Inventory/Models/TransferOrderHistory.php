<?php

namespace Modules\Inventory\Models;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;

class TransferOrderHistory extends Model
{
    use Cloneable;

    protected $table = 'inventory_transfer_order_histories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'created_by', 'transfer_order_id', 'status', 'created_from', 'created_by'];

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'created_by', 'id');
    }

    public function transfer_order()
    {
        return $this->belongsTo('Modules\Inventory\Models\TransferOrder', 'transfer_order_id', 'id');
    }
}
