<?php

namespace Modules\Payroll\Http\Controllers\Common;

use Artisan;
use App\Utilities\Modules;
use Illuminate\Http\Request;
use App\Models\Banking\Account;
use App\Models\Setting\Category;
use Illuminate\Http\JsonResponse;
use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Payroll\Models\Setting\PayItem;
use Modules\Payroll\Jobs\Setting\CreatePayItem;
use Modules\Payroll\Jobs\Setting\DeletePayItem;
use Modules\Payroll\Http\Requests\Common\Setting;

class Settings extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-payroll-payroll')->only(['create', 'store', 'duplicate', 'import']);
        $this->middleware('permission:read-payroll-payroll')->only(['index', 'show', 'edit', 'export']);
        $this->middleware('permission:update-payroll-payroll')->only(['update', 'enable', 'disable']);
        $this->middleware('permission:delete-payroll-payroll')->only('destroy');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $accounts = Account::enabled()->pluck('name', 'id');

        $categories = Category::expense()->enabled()->orderBy('name')->pluck('name', 'id');

        $payment_methods = Modules::getPaymentMethods();

        $benefit_pay_items = PayItem::benefit()->get();
        
        $deduction_pay_items = PayItem::deduction()->get();

        return view('payroll::settings.edit', compact('accounts', 'benefit_pay_items', 'categories', 'deduction_pay_items', 'payment_methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Setting $request)
    {
        $continue_key = ['_token', '_method', 'company_id', 'item_backup', 'items', 'deductions'];

        $this->updatePayItem('benefit', 'addition', $request->items ?? []);
        $this->updatePayItem('deduction', 'subtraction', $request->deductions ?? []);
        
        foreach ($request->request as $key => $value) {
            if (in_array($key, $continue_key)) {
                continue;
            }

            setting()->set('payroll.' . $key, $value);
        }

        setting()->save();

        $response = [
            'status' => null,
            'success' => true,
            'error' => false,
            'data' => null,
            'redirect' => route('payroll.settings.edit'),
        ];

        session(['aka_notify' => $response]);

        if ($response['success']) {
            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function updatePayItem($pay_type, $amount_type, $request)
    {
        $values = [];
        foreach ($request as $value) {
            $pay_item = PayItem::where('pay_type', $pay_type)->where('pay_item', $value['pay_item'])->first();

            if (! $pay_item) {
                $data = [
                    'company_id' => company_id(),
                    'pay_type' => $pay_type,
                    'pay_item' => $value['pay_item'],
                    'amount_type' => $amount_type,
                ];

                $this->ajaxDispatch(new CreatePayItem($data));
            }

            $values[] = $value['pay_item'];
        }

        $this->deletePayItem($pay_type, $values);
    }

    public function deletePayItem($pay_type, $values)
    {
        $pay_items = PayItem::where('pay_type', $pay_type)->get();

        foreach ($pay_items as $pay_item) {
            if (in_array($pay_item->pay_item, $values)) {
                continue;
            }

            $response = $this->ajaxDispatch(new DeletePayItem($pay_item));

            if ($response['error'] == true) {
                $message = $response['message'];
    
                flash($message)->error()->important();
            }
        }
    }
}
