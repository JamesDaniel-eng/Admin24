<?php

namespace Modules\Payroll\Listeners;

use App\Traits\Modules;
use Date;
use Modules\Calendar\Events\CalendarEventCreated as Event;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Models\RunPayroll\RunPayroll;

class AddToEventInCalendar
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('payroll') || ! $this->moduleIsEnabled('calendar')) {
            return;
        }

        if (user()->canAny('read-payroll-pay-calendars')) {
            $pay_calendars = PayCalendar::collect();

            foreach ($pay_calendars as $item) {
                switch ($item->type) {
                    case 'weekly':
                        $date = Date::now()->parse($item->pay_day_mode)->format('Y-m-d');
                        break;

                    case 'bi-weekly':
                        $date = Date::parse(Date::now()->startOfMonth()->addDays(14)->format('Y-m-d') . $item->pay_day_mode)->format('Y-m-d');
                        break;

                    default:
                        if ($item->pay_day_mode == 'specific_day') {
                            $date = Date::now()->startOfMonth()->addDays(--$item->pay_day)->format('Y-m-d');
                        } else {
                            $date = Date::now()->endOfMonth()->format('Y-m-d');
                        }
                        break;
                }

                $event->calendar->events[] = [
                    'title' => $item->name,
                    'start' => $date,
                    'type' => 'payroll-pay-calendars',
                    'id' => $item->id,
                    'backgroundColor' => '#F20089',
                    'borderColor' => '#F20089',
                    'extendedProps' => [
                        'show' => route('payroll.pay-calendars.index'),
                        'edit' => route('payroll.pay-calendars.edit', $item->id),
                        'description' => trans('calendar::general.event_description', ['url' => route('payroll.pay-calendars.index'), 'name' => $item->name]),
                        'date' => $date
                    ],
                ];
            }
        }

        if (user()->canAny('read-payroll-run-payrolls')) {
            $run_payrolls = RunPayroll::collect();

            foreach ($run_payrolls as $item) {
                $event->calendar->events[] = [
                    'title' => $item->name,
                    'start' => Date::parse($item->payment_date)->format('Y-m-d'),
                    'type' => 'payroll-run-payrolls',
                    'id' => $item->id,
                    'backgroundColor' => '#9f99f2',
                    'borderColor' => '#9f99f2',
                    'extendedProps' => [
                        'show' => route('payroll.run-payrolls.show', $item->id),
                        'edit' => route('payroll.run-payrolls.edit', $item->id),
                        'description' => trans('calendar::general.event_description', ['url' => route('payroll.run-payrolls.show', $item->id), 'name' => $item->name]),
                        'date' => Date::parse($item->payment_date)->format('Y-m-d')
                    ],
                ];
            }
        }
    }
}
