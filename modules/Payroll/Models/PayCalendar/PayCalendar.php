<?php

namespace Modules\Payroll\Models\PayCalendar;

use App\Abstracts\Model;
use App\Traits\Currencies;
use Bkwld\Cloner\Cloneable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayCalendar extends Model
{
    use HasFactory;

    use Cloneable, Currencies;

    protected $table = 'payroll_pay_calendars';

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'type_code',
        'pay_day_mode',
        'pay_day_mode_code',
        'pay_day',
    ];

    public $sortable = ['name', 'type'];

    /**
     * Clonable relationships.
     *
     * @var array
     */
    public $cloneable_relations = ['employees'];

    public function employees()
    {
        return $this->hasMany('Modules\Payroll\Models\PayCalendar\Employee', 'pay_calendar_id', 'id');
    }

    public function run_payrolls()
    {
        return $this->hasMany('Modules\Payroll\Models\RunPayroll\RunPayroll', 'pay_calendar_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Setting\Currency', 'currency_code', 'code');
    }

    public static function getAvailableTypes(): array
    {
        return [
            'weekly' => trans('payroll::general.weekly'),
            'bi-weekly' => trans('payroll::general.bi-weekly'),
            'semi-monthly' => trans('payroll::general.semi-monthly'),
            'monthly' => trans('payroll::general.monthly')
        ];
    }

    public static function getPaydayModes(string $type): array
    {
        switch ($type) {
            case 'monthly':
                return [
                    'last_day' => trans('payroll::general.last_day'),
                    'specific_day' => trans('payroll::general.specific_day')
                ];

                break;
            case 'semi-monthly':
                return [
                    'half_month' => trans('payroll::general.half_month'),
                    'last_day' => trans('payroll::general.last_day'),
                ];
                break;
            default:
                return [
                    'Monday' => trans('payroll::general.Monday'),
                    'Tuesday' => trans('payroll::general.Tuesday'),
                    'Wednesday' => trans('payroll::general.Wednesday'),
                    'Thursday' => trans('payroll::general.Thursday'),
                    'Friday' => trans('payroll::general.Friday'),
                    'Saturday' => trans('payroll::general.Saturday'),
                    'Sunday' => trans('payroll::general.Sunday'),
                ];
                break;
        }
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'title' => trans_choice('payroll::general.run_payrolls', 1),
            'icon' => 'directions_run',
            'url' => route('payroll.pay-calendars.run-payrolls.create', $this->id ),
            'permission' => 'create-payroll-pay-calendars',
        ];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('payroll.pay-calendars.edit', $this->id),
            'permission' => 'update-payroll-pay-calendars',
        ];

        $actions[] = [
            'title' => trans('general.duplicate'),
            'icon' => 'file_copy',
            'url' => route('payroll.pay-calendars.duplicate', $this->id),
            'permission' => 'create-payroll-pay-calendars',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('payroll::general.pay_calendars', 1),
            'icon' => 'delete',
            'route' => 'payroll.pay-calendars.destroy',
            'permission' => 'delete-payroll-pay-calendars',
            'model' => $this,
        ];

        return $actions;
    }

    public static function newFactory(): Factory
    {
        return \Modules\Payroll\Database\Factories\PayCalendar::new();
    }
}
