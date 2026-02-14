<?php

namespace Modules\Payroll\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use App\Models\Setting\Currency;
use Modules\Payroll\Http\Requests\Employee\Benefit as Request;
use Modules\Payroll\Models\Employee\Benefit;
use Modules\Payroll\Models\Employee\Employee;
use Modules\Payroll\Models\Setting\PayItem;

class EmployeeBenefits extends Controller
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
        $benefit = Benefit::where('id', $id)->first();

        $html = view('payroll::modals.employees.benefit.show', compact('benefit'))->render();

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
            'onlyonce'   => trans('payroll::benefits.benefit_recurring.onlyonce'),
            'everycheck' => trans('payroll::benefits.benefit_recurring.everycheck'),
            'everymonth' => trans('payroll::benefits.benefit_recurring.everymonth')
        ];

        $type = PayItem::where('company_id', company_id())->where('pay_type', 'benefit')->pluck('pay_item', 'id');

        $employee_id = $employee->id;

        $currency = $employee->contact->currency;

        $html = view('payroll::modals.employees.benefit.create', compact('employee', 'employee_id', 'type', 'recurring', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => [
                'title'   => trans_choice('payroll::general.benefits', 1),
            ],
            'message' => null,
            'html'    => $html,
            'aka_currency' => $currency,
            'all_currencies' => $all_currencies,
        ]);
    }

    public function store(Employee $employee, Request $request)
    {
        Benefit::create([
            'company_id'    => $request->company_id,
            'employee_id'   => $employee->id,
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

        $message = trans('messages.success.added', ['type' => trans_choice('payroll::general.benefits', 1)]);

        flash($message)->success();

        return response()->json($response);
    }

    public function edit(Benefit $benefit)
    {
        $all_currencies = Currency::where('company_id', company_id())->get();
        $recurring = [
            'onlyonce'   => trans('payroll::benefits.benefit_recurring.onlyonce'),
            'everycheck' => trans('payroll::benefits.benefit_recurring.everycheck'),
            'everymonth' => trans('payroll::benefits.benefit_recurring.everymonth')
        ];

        $type = PayItem::where('company_id', company_id())->where('pay_type', 'benefit')->pluck('pay_item', 'id');

        $currency = $benefit->employee->contact->currency;

        $html = view('payroll::modals.employees.benefit.edit', compact('benefit', 'type', 'recurring', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => null,
            'data'    => [
                'title'   => trans('general.title.edit', ['type' => trans_choice('payroll::general.benefits', 1)]),
            ],
            'html'    => $html,
            'aka_currency' => $currency,
            'all_currencies' => $all_currencies,
        ]);
    }

    public function update(Benefit $benefit, Request $request)
    {
        $benefit->update($request->input());

        $response = [
            'success'  => true,
            'error'    => false,
            'redirect' => route('employees.employees.show', ['employee' => $benefit->employee_id, 'tab' => 'payroll']),
            'data'     => [],
            'html'     => null,
        ];

        $message = trans('messages.success.updated', ['type' => trans_choice('payroll::general.benefits', 1)]);

        flash($message)->success();

        return response()->json($response);
    }

    public function destroy(Benefit $benefit)
    {
        $employee = $benefit->employee;

        $benefit->delete();

        $response = [
            'success'  => true,
            'error'    => false,
            'redirect' => route('employees.employees.show', ['employee' => $employee->id, 'tab' => 'payroll']),
            'data'     => [],
        ];

        $message = trans('payroll::benefits.delete');

        flash($message)->success();

        return response()->json($response);
    }
}
