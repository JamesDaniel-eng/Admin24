<?php

return [
    'payment_date' => 'Payment Date',
    'from_date'    => 'From Date',
    'to_date'      => 'To Date',
    'reference'    => 'Reference Field of Payment Run Payroll: :id',
    'not_approved' => 'Not Approved',

    'attachments' => 'Attachment|Attachments',

    'account_is_not_specified' => 'Payroll account isn\'t specified. Set it in the Payroll settings.',

    'status' => [
        'not_approved' => 'Not Approved',
        'approved'     => 'Approved',
    ],

    'form_description' => [
        'active_employees'              => 'The pay calendar will be generated for selected employees,
                                            if necessary you can edit employees on the pay calendar page.',
        'employee_profile_information'  => 'Benefits and deductions should be adjusted for each employee.',
        'benefits'                       => 'Here you can add different pay items such as meals,
                                            expense reimbursement, or bonus.  If necessary, you can adjust
                                            the pay items on the settings page.',
        'deductions'                     => 'Here you can add different pay items such as advance,
                                            leaves, or loan.  If necessary, you can adjust the pay items on
                                            the settings page.',
        'attachment'                     => 'You can add payslips or other required documents here.',
    ],

    'warning' => [
        'employee_main_currency' => "The employee's currency is different from the payment currency in the
                                    run payroll. Therefore, the amounts in the payroll have been converted
                                    to the payroll currency.",
    ],
];
