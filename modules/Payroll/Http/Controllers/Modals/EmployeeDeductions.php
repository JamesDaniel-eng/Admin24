<?php

namespace Modules\Payroll\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use App\Models\Setting\Currency;
use Modules\Payroll\Http\Requests\Employee\Deduction as Request;
use Modules\Payroll\Models\Employee\Deduction;
use Modules\Payroll\Models\Employee\Employee;
use Modules\Payroll\Models\Setting\PayItem;

class EmployeeDeductions extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-payroll-employees')->only(['create', 'store', 'duplicate', 'import']);
        $this->middleware('permission:read-payroll-employees')->only(['index', 'show', 'edit', 'export']);
        $this->middleware('permission:update-payroll-employees')->only(['update', 'enable', 'disable']);
        $this->middleware('permission:delete-payroll-employees')->only('destroy');
    }

    public function show($id)
    {
        $deduction = Deduction::where('id', $id)->first();

        $html = view('payroll::modals.employees.deduction.show', compact('deduction'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => null,
            'html'    => $html,
        ]);
    }

    public function create(Employee $employee)
    {
        $all_currencies = Currency::where('company_id', company_id())->get();
        $recurring = [
            'onlyonce'   => trans('payroll::deductions.deduction_recurring.onlyonce'),
            'everycheck' => trans('payroll::deductions.deduction_recurring.everycheck'),
            'everymonth' => trans('payroll::deductions.deduction_recurring.everymonth')
        ];

        $type = PayItem::where('company_id', company_id())->where('pay_type', 'deduction')->pluck('pay_item', 'id');

        $employee_id = $employee->id;

        $currency = $employee->contact->currency;

        $html = view('payroll::modals.employees.deduction.create', compact('employee', 'employee_id', 'type', 'recurring', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => [
                'title'   => trans_choice('payroll::general.deductions', 1),
            ],
            'message' => null,
            'html'    => $html,
            'aka_currency' => $currency,
            'all_currencies' => $all_currencies,
        ]);
    }

    public function store(Employee $employee, Request $request)
    {
        $deduction = Deduction::create([
            'company_id'    => $request->company_id,
            'employee_id'   => $request->employee_id,
            'type'          => $request->type,
            'amount'        => $request->amount,
            'currency_code' => $employee->contact->currency_code,
            'recurring'     => $request->recurring,
            'description'   => $request->description,
            'from_date'     => $request->from_date,
            'to_date'       => $request->to_date,
        ]);

        $response = [
            'success'  => true,
            'error'    => false,
            'redirect' => route('employees.employees.show', ['employee' => $employee->id, 'tab' => 'payroll']),
            'data'     => [],
            'html'     => null,
        ];

        $message = trans('messages.success.added', ['type' => trans_choice('payroll::general.deductions', 1)]);

        flash($message)->success();

        return response()->json($response);
    }

    public function edit(Deduction $deduction)
    {        
        $all_currencies = Currency::where('company_id', company_id())->get();
        $recurring = [
            'onlyonce'   => trans('payroll::deductions.deduction_recurring.onlyonce'),
            'everycheck' => trans('payroll::deductions.deduction_recurring.everycheck'),
            'everymonth' => trans('payroll::deductions.deduction_recurring.everymonth')
        ];

        $type = PayItem::where('company_id', company_id())->where('pay_type', 'deduction')->pluck('pay_item', 'id');

        $currency = $deduction->employee->contact->currency;

        $html = view('payroll::modals.employees.deduction.edit', compact('type', 'recurring', 'deduction', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => null,
            'data'    => [
                'title'   => trans('general.title.edit', ['type' => trans_choice('payroll::general.deductions', 1)]),
            ],
            'html'    => $html,
            'aka_currency' => $currency,
            'all_currencies' => $all_currencies,
        ]);
    }

    public function update(Deduction $deduction, Request $request)
    {
        $deduction->update($request->input());

        $response = [
            'success'  => true,
            'error'    => false,
            'redirect' => route('employees.employees.show', ['employee' => $deduction->employee_id, 'tab' => 'payroll']),
            'data'     => [],
            'html'     => null,
            'aka_currency' => $currency,
            'all_currencies' => $all_currencies,
        ];

        $message = trans('messages.success.updated', ['type' => trans_choice('payroll::general.deductions', 1)]);

        flash($message)->success();

        return response()->json($response);
    }

    public function destroy(Deduction $deduction)
    {
        $employee = $deduction->employee;

        $deduction->delete();

        $response = [
            'success'  => true,
            'error'    => false,
            'redirect' => route('employees.employees.show', ['employee' => $employee->id, 'tab' => 'payroll']),
            'data'     => [],
        ];

        $message = trans('payroll::deductions.delete');

        flash($message)->success();

        return response()->json($response);
    }
}
