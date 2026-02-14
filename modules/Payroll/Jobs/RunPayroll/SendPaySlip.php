<?php

namespace Modules\Payroll\Jobs\RunPayroll;

use App\Abstracts\Job;
use App\Events\Document\DocumentSending;
use App\Events\Document\DocumentSent;
use App\Http\Requests\Common\CustomMail as Request;
use App\Models\Document\Document;
use Modules\Payroll\Notifications\PaySlip as Notification;

class SendPaySlip extends Job
{
    public $request;
    public $run_payroll;
    public $employee;

    public function __construct(Request $request, $run_payroll, $employee)
    {
        $this->request = $request;
        $this->run_payroll = $run_payroll;
        $this->employee = $employee;
    }

    public function handle(): void
    {
        $mail_request = $this->request->only(['to', 'subject', 'body']);

        $attachments = collect($this->request->get('attachments', []))
            ->filter(fn($value) => $value == true)
            ->keys()
            ->all();

        $attach_pdf = in_array('pdf', $attachments);

        $custom_mail = [
            'subject'   => $mail_request['subject'],
            'body'      => $mail_request['body'],
        ];

        if ($this->request->get('user_email', false)) {
            $custom_mail['bcc'] = user()->email;
        }

        $this->employee->contact->notify(new Notification($this->run_payroll, $this->employee, 'payroll_pay_slip', $attach_pdf, $custom_mail, $attachments));
    }
}
