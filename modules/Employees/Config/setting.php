<?php

return [

    'fallback' => [
        'employees' => [
            'dismissal_types' => env('SETTING_FALLBACK_EMPLOYEES_DISMISSAL_TYPES', json_encode([
                'Fired', 'Resigned', 'Retired', 'Laid off', 'Others'
            ])),
        ],
    ],
];
