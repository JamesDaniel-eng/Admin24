<?php

namespace Modules\Payroll\Http\ViewComposers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Payroll\Models\Employee\Employee;
use Modules\Payroll\Models\RunPayroll\RunPayrollEmployee;

class AddPayrollTab
{
    public $view;

    public function compose(View $view)
    {
        if (user()->cannot('read-payroll-payroll')) {
            return;
        }

        $this->view = $view;

        $this->showContent();
    }

    public function showContent(): void
    {
        $employee = $this->view->getData()['employee'];
        $employee = Employee::findOrFail($employee->id);

        $payments = $this->getPayments($employee);

        $total_payment = $total_deduction = $total_benefit = 0;

        foreach ($payments as $payment) {
            $total_payment += $payment->total;
            $total_deduction += $payment->deduction;
            $total_benefit += $payment->benefit;
        }

        $total_amount = money($total_payment, $employee->contact->currency->code, true);
        $deduction_amount = money($total_deduction, $employee->contact->currency->code, true);
        $benefit_amount = money($total_benefit, $employee->contact->currency->code, true);

        $summary_amounts = [
            'total_exact'           => $total_amount->format(),
            'total_for_humans'      => $total_amount->formatForHumans(),
            'deduction_exact'       => $deduction_amount->format(),
            'deduction_for_humans'  => $deduction_amount->formatForHumans(),
            'benefit_exact'         => $benefit_amount->format(),
            'benefit_for_humans'    => $benefit_amount->formatForHumans(),
        ];

        $limit = request('limit', setting('default.list_limit', '25'));

        $this->view->getFactory()->startPush(
            'payroll_employee_content',
            view('payroll::partials.employee.tab_content',
                [
                    'unmatched_transactions' => $this->paginate($payments, $limit),
                    'limits' => ['10' => '10', '25' => '25', '50' => '50', '100' => '100']
                ], compact('employee', 'payments', 'summary_amounts')
            )
        );
    }

    public function getPayments(Employee $employee)
    {
        return RunPayrollEmployee::where('employee_id', $employee->id)
            ->with('run_payroll')
            ->whereHas('run_payroll', function ($query) {
                $query->where('status', 'approved');
            })
            ->sortable(['run_payroll.payment_date' => 'desc'])
            ->collect();
    }
    
    /**
     * Generate a pagination collection.
     *
     * @param array|Collection $payments
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($payments, $perPage = 15, $page = null, $options = [])
    {
        $perPage = $perPage ?: request('limit', setting('default.list_limit', '25'));

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $payments = $payments instanceof Collection ? $payments : Collection::make($payments);

        return new LengthAwarePaginator($payments->forPage($page, $perPage), $payments->count(), $perPage, $page, $options);
    }
}
