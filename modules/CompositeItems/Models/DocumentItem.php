<?php

namespace Modules\CompositeItems\Models;

use App\Abstracts\Model;

class DocumentItem extends Model
{
    protected $table = 'composite_items_document_items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'type',
        'document_id',
        'document_item_id',
        'item_id',
        'warehouse_id',
        'quantity',
        'price',
        'tax',
        'discount_type',
        'discount_rate',
        'total',
        'created_from',
        'created_by'
    ];

    protected $appends = [
        'discount'
    ];

    public function document()
    {
        return $this->belongsTo('App\Models\Document\Document');
    }

    public function document_item()
    {
        return $this->belongsTo('App\Models\Document\DocumentItem');
    }

    public function document_items()
    {
        return $this->hasMany('App\Models\Document\DocumentItem', 'document_id', 'document_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item');
    }

    public function warehouse()
    {
        return $this->belongsTo('Modules\Inventory\Models\Warehouse');
    }

    public function getDiscountAttribute(): string
    {
        if (setting('localisation.percent_position', 'after') === 'after') {
            $text = ($this->discount_type === 'normal') ? $this->discount_rate . '%' : $this->discount_rate;
        } else {
            $text = ($this->discount_type === 'normal') ? '%' . $this->discount_rate : $this->discount_rate;
        }

        return $text;
    }
}
