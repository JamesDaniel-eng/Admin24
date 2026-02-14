<?php

namespace Modules\Admin24\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseAccount extends Model
{
    use HasFactory;

    protected $table = 'admin24_expense_accounts';

    protected $fillable = ["business_id", "name", "account", "type", "desc"];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Admin24\Database\Factories\ExpenseAccounts::new();
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
