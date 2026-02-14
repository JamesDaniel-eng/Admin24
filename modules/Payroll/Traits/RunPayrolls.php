<?php

namespace Modules\Payroll\Traits;

use App\Models\Common\Media;
use App\Utilities\Modules;
use App\Traits\DateTime;
use Date;
use File;
use Illuminate\Support\Facades\Log;
use Image;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Support\Facades\Storage;
use Modules\Payroll\Models\RunPayroll\RunPayroll;
use Modules\Payroll\Models\Setting\PayItem;
use Modules\Payroll\Services\RunPayroll as RunPayrollService;
use Carbon\Carbon;

trait RunPayrolls
{
    use DateTime;

    /**
     * Generate next run payroll number
     *
     * @return string
     */
    public function getNextRunPayrollNumber()
    {
        $prefix = setting('payroll.run_payroll_prefix', 'PR-');
        $next = setting('payroll.run_payroll_next', '1');
        $digit = setting('payroll.run_payroll_digit', '5');

        $number = $prefix . str_pad($next, $digit, '0', STR_PAD_LEFT);

        return $number;
    }

    /**
     * Increase the next run payroll number
     */
    public function increaseNextRunPayrollNumber()
    {
        // Update next run payroll number
        $next = setting('payroll.run_payroll_next', 1) + 1;

        setting(['payroll.run_payroll_next' => $next]);
        setting()->save();
    }

    protected function getLogo()
    {
        $media = Media::find(setting('company.logo'));

        if (!empty($media)) {
            $path = $media->getDiskPath();

            if (Storage::missing($path)) {
                return ;
            }
        } else {
            $path = base_path('public/img/company.png');
        }

        try {
            $image = Image::cache(function($image) use ($media, $path) {
                $width = setting('invoice.logo_size_width');
                $height = setting('invoice.logo_size_height');

                if ($media) {
                    $image->make(Storage::get($path))->resize($width, $height)->encode();
                } else {
                    $image->make($path)->resize($width, $height)->encode();
                }
            });
        } catch (NotReadableException | \Exception $e) {
            Log::info('Company ID: ' . company_id() . ' modules/Payroll/RunPayroll/PaySlips.php exception.');
            Log::info($e->getMessage());

            $path = base_path('public/img/company.png');

            $image = Image::cache(function($image) use ($path) {
                $width = setting('invoice.logo_size_width');
                $height = setting('invoice.logo_size_height');

                $image->make($path)->resize($width, $height)->encode();
            });
        }

        if (empty($image)) {
            return;
        }

        $extension = File::extension($path);

        return 'data:image/' . $extension . ';base64,' . base64_encode($image);
    }

    public function getPaySlipData(RunPayroll $runPayroll, $employee_id): array
    {
        $run_payroll_employee = $runPayroll->employees()
            ->where('employee_id', $employee_id)
            ->first();

        $pay_types = PayItem::pluck('pay_item','id');

        $benefits = $deductions = [];

        $salary_amount = $this->getSalary($runPayroll->pay_calendar->type, $run_payroll_employee->employee);

        $employee_currency = $run_payroll_employee->employee->contact->currency;

        $is_main_currency = $runPayroll->currency_code != $employee_currency->code;

        if ($is_main_currency) {
            $main_currency_salary = $salary_amount;
            $salary_amount = $this->convertCurrencyRate($salary_amount, $employee_currency->rate, $runPayroll->currency->rate);
        }

        $salary = money($salary_amount, $runPayroll->currency_code , true)->format();

        $total_benefits = $total_deductions = $main_total_cur_ben = $main_total_cur_ded = 0;

        $_benefits = $run_payroll_employee->benefits()->where('run_payroll_id', $runPayroll->id)->get();

        foreach ($_benefits as $benefit) {
            if ($is_main_currency) {
                $main_total_cur_ben += $benefit->amount;
                $benefit->amount = $this->convertCurrencyRate($benefit->amount, $employee_currency->rate, $runPayroll->currency->rate);
            }    

            $benefits[] = [
                'name' => isset($pay_types[$benefit->type]) ? $pay_types[$benefit->type] : trans('general.na'),
                'amount' => money($benefit->amount, $runPayroll->currency_code, true)->format()
            ];

            $total_benefits += $benefit->amount;
        }

        $_deductions = $run_payroll_employee->deductions()->where('run_payroll_id', $runPayroll->id)->get();

        foreach ($_deductions as $deduction) {
            if ($is_main_currency) {
                $main_total_cur_ded += $deduction->amount;
                $deduction->amount = $this->convertCurrencyRate($deduction->amount, $employee_currency->rate, $runPayroll->currency->rate);
            }    

            $deductions[] = [
                'name' => isset($pay_types[$deduction->type]) ? $pay_types[$deduction->type] : trans('general.na'),
                'amount' => money($deduction->amount, $runPayroll->currency_code, true)->format()
            ];

            $total_deductions += $deduction->amount;
        }

        $payment_methods = Modules::getPaymentMethods();

        // Share date format
        $date_format = user() ? $this->getCompanyDateFormat() : 'd F Y';

        $total_amount = ($salary_amount + $total_benefits) - $total_deductions;

        $main_total_amount = (($main_currency_salary ?? 0) + $main_total_cur_ben) - $main_total_cur_ded;

        return [
            'name' => $run_payroll_employee->employee->contact->name,
            'location' => $run_payroll_employee->employee->contact->location,
            'phone' => $run_payroll_employee->employee->contact->phone,
            'email' => $run_payroll_employee->employee->contact->email,
            'logo' => $this->getLogo(),
            'payment_date' => Date::parse($runPayroll->payment_date)->format($date_format),
            'tax_number' => $run_payroll_employee->employee->contact->tax_number ?? '-',
            'bank_account_number' => $run_payroll_employee->employee->bank_account_number ?? '-',
            'payment_method' => isset($payment_methods[$runPayroll->payment_method]) ? $payment_methods[$runPayroll->payment_method] : '-',
            'department' => $run_payroll_employee->employee->department->name,
            'from_date' => Date::parse($runPayroll->from_date)->format($date_format),
            'to_date' => Date::parse($runPayroll->to_date)->format($date_format),
            'salary' => $salary,
            'benefits' => $benefits,
            'deductions' => $deductions,
            'total' => money($total_amount, $runPayroll->currency_code, true)->format(),
            'is_main_currency' => $is_main_currency,
            'main_currency_salary' => money($main_currency_salary ?? 0, $employee_currency->code, true)->format(),
            'main_currency_total_benefit' => money($main_total_cur_ben, $employee_currency->code, true)->format(),
            'main_currency_total_deduction' => money($main_total_cur_ded, $employee_currency->code, true)->format(),
            'main_currency_total_amount' => money($main_total_amount, $employee_currency->code, true)->format(),
        ];
    }

    public function getSalary($pay_calendar_type, $employee)
    {
        switch ($pay_calendar_type) {
            case 'weekly':
                switch ($employee->salary_type) {
                    case 'weekly':
                        $salary_amount = $employee->amount;
                        break;
                    case 'bi-weekly':
                        $salary_amount = $employee->amount / 2;
                        break;
                    case 'semi-monthly':
                        $salary_amount = $employee->amount / 2; // 26 / 12 ≈ 2.1667
                        break;
                    case 'monthly':
                        $salary_amount = $employee->amount / 4;
                        break;
                    case 'yearly':
                        $salary_amount = $employee->amount / 52;
                        break;
                    default:
                        $salary_amount = $employee->amount;
                        break;
                }
                break;

            case 'bi-weekly':
                switch ($employee->salary_type) {
                    case 'weekly':
                        $salary_amount = $employee->amount * 2;
                        break;
                    case 'bi-weekly':
                        $salary_amount = $employee->amount;
                        break;
                    case 'semi-monthly':
                        $salary_amount = $employee->amount; // 26 / 24 ≈ 1.0833
                        break;
                    case 'monthly':
                        $salary_amount = $employee->amount / 2;
                        break;
                    case 'yearly':
                        $salary_amount = $employee->amount / 26;
                        break;
                    default:
                        $salary_amount = $employee->amount;
                        break;
                }
                break;

            case 'semi-monthly':
                switch ($employee->salary_type) {
                    case 'weekly':
                        $salary_amount = $employee->amount * 2; // 26 / 12 ≈ 2.1667
                        break;
                    case 'bi-weekly':
                        $salary_amount = $employee->amount; // 26 / 24 ≈ 1.0833
                        break;
                    case 'semi-monthly':
                        $salary_amount = $employee->amount;
                        break;
                    case 'monthly':
                        $salary_amount = $employee->amount / 2;
                        break;
                    case 'yearly':
                        $salary_amount = $employee->amount / 24;
                        break;
                    default:
                        $salary_amount = $employee->amount;
                        break;
                }
                break;

            case 'monthly':
            default:
                switch ($employee->salary_type) {
                    case 'weekly':
                        $salary_amount = $employee->amount * 4;
                        break;
                    case 'bi-weekly':
                        $salary_amount = $employee->amount * 2;
                        break;
                    case 'semi-monthly':
                        $salary_amount = $employee->amount * 2;
                        break;
                    case 'monthly':
                        $salary_amount = $employee->amount;
                        break;
                    case 'yearly':
                        $salary_amount = $employee->amount / 12;
                        break;
                    default:
                        $salary_amount = $employee->amount;
                        break;
                }
                break;
        }

        return round($salary_amount, 2);
    }

    public function getBenefits($pay_calendar_type, $employee, $benefits = null)
    {
        if (empty($benefits)) {
            $run_payroll_service = new RunPayrollService(new RunPayroll([
                'from_date' => Carbon::now()->startOfMonth(),
                'to_date'   => Carbon::now()->endOfMonth(),
            ]));
            
            $benefits = $run_payroll_service->determineBenefits($employee);
        }

        $benefit_amount = 0;

        foreach ($benefits as $benefit) {
            switch ($pay_calendar_type) {
                case 'monthly':
                    $benefit_amount += $benefit->amount;
                    break;
                default:
                    if ($employee->salary_type != 'monthly' && ($benefit->recurring == 'everycheck' || $benefit->recurring == 'onlyonce')) {
                        $benefit_amount += $benefit->amount;
                    }
                break;
            }
        }

        return $benefit_amount;
    }

    public function getDeductions($pay_calendar_type, $employee, $deductions = null)
    {
        if (empty($deductions)) {
            $run_payroll_service = new RunPayrollService(new RunPayroll([
                'from_date' => Carbon::now()->startOfMonth(),
                'to_date'   => Carbon::now()->endOfMonth(),
            ]));

            $deductions = $run_payroll_service->determineDeductions($employee);
        }

        $deduction_amount = 0;

        foreach ($deductions as $deduction) {
            switch ($pay_calendar_type) {
                case 'monthly':
                    $deduction_amount += $deduction->amount;
                    break;
                default:
                    if ($employee->salary_type != 'monthly' && ($deduction->recurring == 'everycheck' || $deduction->recurring == 'onlyonce')) {
                        $deduction_amount += $deduction->amount;
                    }
                break;
            }
        }

        return $deduction_amount;
    }

    public function convertCurrencyRate($amount, $from_rate, $to_rate)
    {
        return ($amount / $from_rate) * $to_rate;
    }

    public function storePaySlipPdfAndGetPath($run_payroll, $employee)
    {
        $pay_slip = $run_payroll->employees()
            ->where('employee_id', $employee->id)
            ->first();

        $data = $this->getPaySlipData($pay_slip->run_payroll, $pay_slip->employee_id);

        $view = view('payroll::modals.run-payrolls.pay_slips.print', compact('data'));

        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);

        $file_name = $employee->name . '-' . $run_payroll->name . '.pdf';

        $pdf_path = get_storage_path('app/temp/' . $file_name);

        // Save the PDF file into temp folder
        $pdf->save($pdf_path);

        return $pdf_path;
    }
}
