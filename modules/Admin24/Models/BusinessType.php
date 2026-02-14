<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessType extends Model
{
    use HasFactory;

    protected $table = 'admin24_business_types';

    protected $fillable = ['code', 'name'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\BusinessType::new();
    }
}
