<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;

    protected $table = 'admin24_businesses';

    protected $fillable = ["name","sub_no","email","reg_no","type","bk_method"];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\Business::new();
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function expenseAccounts(): HasMany
    {
        return $this->hasMany(ExpenseAccount::class);
    }

    public function incomeAccounts(): HasMany
    {
        return $this->hasMany(IncomeAccount::class);
    }
}
