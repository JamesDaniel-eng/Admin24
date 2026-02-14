<?php

return [

    'payroll_pay_slip' => [
        'title' => 'Payslip Template (sent to employee)',
        'subject' => 'Your Payslip for {payslip_period}',
        'body' => 'Dear {employee_name},<br /><br />Your payslip for the period <strong>{payslip_period}</strong> is now available. Please find the details below:<br /><br />Salary: <strong>{salary}</strong><br /><br />Benefits: <strong>{benefits}</strong><br /><br />Deductions: <strong>{deductions}</strong><br /><br />Total Payment: <strong>{total}</strong><br /><br />Payment Date: <strong>{payment_date}</strong><br /><br />If you have any questions, feel free to reach out to HR or your manager.<br /><br />Best Regards,<br />{company_name}',
    ],
    
];
