<?php

namespace Modules\Admin24\Models;

use App\Models\Common\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoreItem extends Item
{
    use HasFactory;

    protected $fillable = ['company_id', 'type', 'name', 'description', 'sale_price', 'purchase_price', 'category_id', 'enabled', 'created_from', 'created_by', 'created_at'];    
}
