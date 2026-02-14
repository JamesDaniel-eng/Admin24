<?php

namespace Modules\Payroll\Http\Controllers\RunPayrolls;

use App\Abstracts\Http\Controller;
use App\Utilities\Modules;
use App\Traits\DateTime;
use Date;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Payroll\Models\PayCalendar\PayCalendar;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Payroll\Models\Setting\PayItem;
use Modules\Payroll\Services\RunPayroll as RunPayrollService;
use Modules\Payroll\Traits\RunPayrolls;

class PaySlips extends Controller
{
    use DateTime, RunPayrolls;

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

    public function index(PayCalendar $payCalendar, RunPayroll $runPayroll): JsonResponse
    {
        $employees = (new RunPayrollService($runPayroll))->getEmployeesForSelectBox();

        $logo = $this->getLogo();

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => view('payroll::modals.run-payrolls.pay_slips.index', compact('payCalendar', 'runPayroll', 'employees', 'logo'))->render(),
        ]);
    }

    public function store(PayCalendar $payCalendar, RunPayroll $runPayroll, Request $request): JsonResponse
    {
        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('payroll.pay-calendars.run-payrolls.approvals.edit', [$payCalendar->id, $runPayroll->id]),
            'data' => [],
        ];

        return response()->json($response);
    }

    public function edit(RunPayroll $runPayroll): JsonResponse
    {
        $payCalendar = $runPayroll->pay_calendar;

        $employees = (new RunPayrollService($runPayroll))->getEmployeesForSelectBox();

        $logo = $this->getLogo();

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => view('payroll::modals.run-payrolls.pay_slips.index', compact('payCalendar', 'runPayroll', 'employees', 'logo'))->render(),
        ]);
    }

    public function employee(PayCalendar $payCalendar, RunPayroll $runPayroll, $employee_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'errors' => false,
            'data' => $this->getPaySlipData($runPayroll, $employee_id),
        ]);
    }

    public function print(PayCalendar $payCalendar, RunPayroll $runPayroll, $employee_id)
    {
        return view('payroll::modals.run-payrolls.pay_slips.print', [
            'data' => $this->getPaySlipData($runPayroll, $employee_id),
        ]);
    }
}
