<?php

namespace Modules\Payroll\Models\Setting;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayItem extends Model
{
    use HasFactory;

    protected $table = 'payroll_setting_pay_items';

    protected $fillable = [
        'company_id',
        'pay_type',
        'pay_item',
        'amount_type',
        'code'
    ];

    public function benefits()
    {
        return $this->hasMany('Modules\Payroll\Models\Employee\Benefit', 'type', 'id');
    }

    public function deductions()
    {
        return $this->hasMany('Modules\Payroll\Models\Employee\Deduction', 'type', 'id');
    }

    public function scopeBenefit(Builder $query): Builder
    {
        return $query->where('pay_type', '=', 'benefit');
    }

    public function scopeDeduction(Builder $query): Builder
    {
        return $query->where('pay_type', '=', 'deduction');
    }

    public static function newFactory(): Factory
    {
        return \Modules\Payroll\Database\Factories\PayItem::new();
    }
}
