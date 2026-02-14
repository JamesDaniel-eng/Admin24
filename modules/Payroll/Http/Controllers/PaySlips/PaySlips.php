<?php

namespace Modules\Payroll\Http\Controllers\PaySlips;

use App\Abstracts\Http\Controller;
use App\Models\Common\Contact;
use Modules\Payroll\Traits\RunPayrolls;
use Modules\Payroll\Models\Employee\Employee;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployee;

class PaySlips extends Controller
{
    use RunPayrolls;

    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:read-payroll-pay-slips')->only(['index', 'show', 'export']);
    }

    public function index()
    {
        $contact = Contact::where('user_id', user()->id)->first();

        $employee = Employee::where('contact_id', $contact->id)->first();

        $pay_slips = RunPayrollEmployee::where('employee_id', $employee->id)
                                        ->with('run_payroll')
                                        ->whereHas('run_payroll', function ($query) {
                                            $query->where('status', 'approved');
                                        })
                                        ->sortable(['run_payroll.payment_date' => 'desc'])
                                        ->collect();

        return view('payroll::pay-slips.index', compact('pay_slips'));
    }

    public function show(RunPayrollEmployee $pay_slip)
    {
        $data = $this->getPaySlipData($pay_slip->run_payroll, $pay_slip->employee_id);

        return view('payroll::pay-slips.show', compact('pay_slip', 'data'));
    }

    /**
     * Print the payslip.
     *
     * @param  RunPayrollEmployee $pay_slip
     *
     * @return Response
     */
    public function print(RunPayrollEmployee $pay_slip)
    {
        $data = $this->getPaySlipData($pay_slip->run_payroll, $pay_slip->employee_id);

        $view = view('payroll::pay-slips.print', compact('pay_slip', 'data'));

        return mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');
    }

    /**
     * Download the PDF file of payslip.
     *
     * @param  RunPayrollEmployee $pay_slip
     *
     * @return Response
     */
    public function pdf(RunPayrollEmployee $pay_slip)
    {
        $data = $this->getPaySlipData($pay_slip->run_payroll, $pay_slip->employee_id);

        $view = view('payroll::pay-slips.print', compact('pay_slip', 'data'));

        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);

        //$pdf->setPaper('A4', 'portrait');

        $file_name = $pay_slip->employee->name . ' - ' . $pay_slip->run_payroll->name . '.pdf';

        return $pdf->download($file_name);
    }
}
