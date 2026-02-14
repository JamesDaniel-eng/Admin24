<?php

return [
    'name'        => 'Payroll',
    'description' => 'Manage employee salaries easy and automate payments',

    'payrolls'          => 'Payrolls',
    'employees'         => 'Employee|Employees',
    'benefits'          => 'Benefit|Benefits',
    'deductions'        => 'Deduction|Deductions',
    'salaries'          => 'Salary|Salaries',
    'pay_calendars'     => 'Pay Calendar|Pay Calendars',
    'variables'         => 'Variable Input',
    'pay_slips'         => 'Payslip|Payslips',
    'approval'          => 'Approval',
    'active_employee'   => 'Active Employee',
    'advanced'          => 'Advanced',
    'setting'           => 'Setting',
    'dashboard'         => 'Dashboard',
    'recurring'         => 'Recurring',
    'run_payrolls'      => 'Run Payroll|Run Payrolls',
    'summary_reports'   => 'Summary Report|Summary Reports',
    'employee_reports'  => 'Detailed Report|Detailed Reports',


    'next'                         => 'Next',
    'approve'                      => 'Approve',
    'add_benefit'                  => 'Add Benefit',
    'add_deduction'                => 'Add Deduction',
    'employee_profile_information' => 'Employee Profile Information',
    'additional_allowance'         => 'Additional allowance or deduction for this pay run only',
    'pay_slip_title'               => 'Employee Payslip',
    'ready_approve'                => 'Ready to Approve',

    'weekly'       => 'Weekly',
    'bi-weekly'    => 'Bi-Weekly',
    'semi-monthly' => 'Semi-Monthly',
    'monthly'      => 'Monthly',
    'Monday'       => 'Monday',
    'Tuesday'      => 'Tuesday',
    'Wednesday'    => 'Wednesday',
    'Thursday'     => 'Thursday',
    'Friday'       => 'Friday',
    'Saturday'     => 'Saturday',
    'Sunday'       => 'Sunday',
    'half_month'   => 'The first business day after the middle of the month',
    'last_day'     => 'Last working day of the month',
    'specific_day' => 'Specific day each month',

    'employee_summary'                      => 'Employee Summary',
    'description_employee_summary'          => 'Run Payroll Summary report.',
    'employee_detailed'                     => 'Employee Detailed',
    'description_employee_detailed'         => 'Run Payroll report detail by employee.',
    'expense_summary'                       => 'Expense Summary (Employee)',
    'description_expense_summary'           => 'Monthly expense summary by employee.',
    'benefit_deduction_summary'             => 'Benefit vs Deduction Summary',
    'description_benefit_deduction_summary' => 'Benefit vs Deduction Summary report.',

    'from_date' => 'From Date',
    'to_date'   => 'To Date',

    'wizard' => [
        'run_payroll' => 'Run Payroll',
        'employees'   => 'Run Employees',
        'variables'   => 'Run Variables',
        'payslips'    => 'Run Payslips',
        'approval'    => 'Run Approval'
    ],

    'no_records' => [
        'employee'   => "This employee has no approved payroll yet. When you run the pay calendar and approve it, all the employee's payroll history will be listed here",
    ],

    'total'   => 'Total :type',
    'add_new' => 'Add New :type',

    'empty' => [
        'pay_calendars' => "The payroll app allows you to create dynamic weekly, bi-weekly or monthly pay calendars to pay 
                            your employees. You can set basic pay or salary, including fixed amount payments 
                            (allowance or deduction) for your employees.",
        'run_payrolls'  => "Run payroll calendars listed here and can be approved, edited, or removed.  While running a pay
                            calendar, you can add pay items (allowance or deduction) for each employee. ",
        'pay_slips'     => "Pay slips provide a detailed breakdown of employee earnings, deductions, and net pay for each pay period. 
                            You can generate and customize pay slips for all employees, ensuring transparency and accuracy in payroll 
                            processing. Each pay slip includes essential information such as basic salary, allowances, deductions, 
                            and year-to-date totals."
    ]
];