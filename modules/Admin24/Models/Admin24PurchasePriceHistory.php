<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin24PurchasePriceHistory extends Model
{
    use HasFactory;

    protected $table = 'admin24_purchase_price_histories';

    protected $fillable = ['company_id', 'user_id', 'item_id', 'purchase_price', 'price_date', 'created_at'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\PurchasePriceHistory::new();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(App\Models\Common\Item::class);
    }
}
