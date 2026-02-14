<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin24Quantities extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company_id', 'user_id', 'item_id', 'ratio', 'multiplier'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\Admin24Quantities::new();
    }
}
