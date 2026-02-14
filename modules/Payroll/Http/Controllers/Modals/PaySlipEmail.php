<?php

namespace Modules\Payroll\Http\Controllers\Modals;

use App\Traits\Emails;
use Illuminate\Http\JsonResponse;
use App\Abstracts\Http\Controller;
use Modules\Employees\Models\Employee;
use Modules\Payroll\Jobs\RunPayroll\SendPaySlip;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use App\Http\Requests\Common\CustomMail as Request;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Notifications\PaySlip as Notification;

class PaySlipEmail extends Controller
{
    use Emails;

    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-payroll-run-payrolls')->only(['create', 'store', 'duplicate', 'import']);
        $this->middleware('permission:read-payroll-run-payrolls')->only(['index', 'show', 'edit', 'export']);
        $this->middleware('permission:update-payroll-run-payrolls')->only(['update', 'enable', 'disable']);
        $this->middleware('permission:delete-payroll-run-payrolls')->only('destroy');
    }

    public function create(PayCalendar $payCalendar, RunPayroll $runPayroll, Employee $employee)
    {
        $notification = new Notification($runPayroll, $employee, 'payroll_pay_slip', true);

        $html = view('payroll::modals.run-payrolls.pay_slips.email', compact('payCalendar', 'runPayroll', 'employee', 'notification'))->render();

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => $html,
            'data' => [
                'title' => trans('general.title.new', ['type' => trans_choice('general.email', 1)]),
                'buttons' => [
                    'cancel' => [
                        'text' => trans('general.cancel'),
                        'class' => 'btn-outline-secondary',
                    ],
                    'confirm' => [
                        'text' => trans('general.send'),
                        'class' => 'disabled:bg-green-100',
                    ]
                ]
            ]
        ]);
    }

    public function store(PayCalendar $payCalendar, RunPayroll $runPayroll, Employee $employee, Request $request): JsonResponse
    {
        $response = $this->sendEmail(new SendPaySlip($request, $runPayroll, $employee));

        if ($response['success']) {
            $response['message'] = trans('payroll::messages.pay_slip_email_sent', ['employee' => $employee->name]);
        }

        return response()->json($response);
    }
}
