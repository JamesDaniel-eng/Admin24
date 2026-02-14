<?php

use Modules\Payroll\Models\PayCalendar\PayCalendar;

return [
    PayCalendar::class => [
        [
            'location' => [
                'code' => 'payroll-pay-calendars',
                'name' => 'payroll::general.pay_calendars',
            ],
            'sort_orders' => [
                'name'                  => 'general.name',
                'type'                  => ['general.types', 1],
            ],
            'views' => [
                'crud' => [
                    'payroll::pay-calendars.create',
                    'payroll::pay-calendars.edit'
                ],
                'show' => [
                ],
            ],
        ],
    ],
];
