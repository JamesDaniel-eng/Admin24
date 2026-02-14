<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessIndustry extends Model
{
    use HasFactory;

    protected $table = 'admin24_business_industries';

    protected $fillable = ['naics', 'name'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\BusinessIndustry::new();
    }
}
