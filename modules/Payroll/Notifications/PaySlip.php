<?php

namespace Modules\Payroll\Notifications;

use App\Abstracts\Notification;
use Illuminate\Mail\Attachment;
use App\Models\Setting\EmailTemplate;
use Modules\Employees\Models\Employee;
use Modules\Payroll\Traits\RunPayrolls;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Illuminate\Notifications\Messages\MailMessage;

class PaySlip extends Notification
{
    use RunPayrolls;

    /**
     * The run_payroll model.
     *
     * @var object
     */
    public $run_payroll;

    /**
     * The employee model.
     *
     * @var object
     */
    public $employee;

    /**
     * The email template.
     *
     * @var EmailTemplate
     */
    public $template;

    /**
     * Should attach pdf or not.
     *
     * @var bool
     */
    public $attach_pdf;

    /**
     * List of document attachments to attach when sending the email.
     *
     * @var array
     */
    public $attachments;

    /**
     * Create a notification instance.
     */
    public function __construct(RunPayroll $run_payroll = null, Employee $employee = null, string $template_alias = null, bool $attach_pdf = false, array $custom_mail = [], $attachments = [])
    {
        parent::__construct();

        $this->run_payroll = $run_payroll;
        $this->employee = $employee;
        $this->template = EmailTemplate::alias($template_alias)->first();
        $this->attach_pdf = $attach_pdf;
        $this->custom_mail = $custom_mail;
        $this->attachments = $attachments;
    }


    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        if (!empty($this->custom_mail['to'])) {
            $notifiable->email = $this->custom_mail['to'];
        }

        $message = $this->initMailMessage();

        $func = is_local_storage() ? 'fromPath' : 'fromStorage';

        // Attach the PDF file
        if ($this->attach_pdf) {
            $path = $this->storePaySlipPdfAndGetPath($this->run_payroll, $this->employee);
            $file = Attachment::$func($path)->withMime('application/pdf');

            $message->attach($file);
        }

        return $message;
    }

    public function getTags(): array
    {
        return [
            '{employee_name}',
            '{payslip_period}',
            '{salary}',
            '{deductions}',
            '{benefits}',
            '{total}',
            '{payment_date}',
            '{company_name}',
        ];
    }

    public function getTagsReplacement(): array
    {
        $data = $this->getPaySlipData($this->run_payroll, $this->employee->id);

        return [
            $data['name'],
            $data['from_date'] . ' - ' . $data['to_date'],
            $data['main_currency_salary'],
            $data['main_currency_total_deduction'],
            $data['main_currency_total_benefit'],
            $data['main_currency_total_amount'],
            $data['payment_date'],
            $this->run_payroll->company->name,
        ];
    }
}
