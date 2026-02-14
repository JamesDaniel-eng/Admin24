<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessBookKeepingMethod extends Model
{
    use HasFactory;

    protected $table = 'admin24_business_book_keeping_methods';

     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $fillable = ['code', 'name'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\BusinessBookKeepingMethod::new();
    }
}
