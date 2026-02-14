<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'inventory_warehouses';

    protected $fillable = ['company_id', 'address', 'country', 'city', 'zip_code', 'state', 'description', 'email', 'enabled', 'name', 'phone', 'created_from', 'created_by'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\Warehouse::new();
    }
}
