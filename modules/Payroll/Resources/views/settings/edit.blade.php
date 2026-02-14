<x-layouts.admin>
    <x-slot name="title">{{ trans('payroll::general.name') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="POST" route="payroll.settings.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('payroll::general.run_payrolls', 1) }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="run_payroll_prefix" label="{{ trans('settings.invoice.prefix') }}" :value="old('run_payroll_prefix', setting('payroll.run_payroll_prefix'))" />
                    
                        <x-form.group.text name="run_payroll_digit" label="{{ trans('settings.invoice.digit') }}" :value="old('run_payroll_digit', setting('payroll.run_payroll_digit'))" />

                        <x-form.group.text name="run_payroll_next" label="{{ trans('settings.invoice.next') }}" :value="old('run_payroll_next', setting('payroll.run_payroll_next'))" />

                        <x-form.group.select name="account" label="{{ trans_choice('general.accounts', 1) }}" :options="$accounts" :selected="old('account', setting('payroll.account'))" form-group-class="sm:col-span-3" />
                    
                        <x-form.group.select name="category" label="{{ trans_choice('general.categories', 1) }}" :options="$categories" :selected="setting('payroll.category')" form-group-class="sm:col-span-3" />

                        <x-form.group.select name="payment_method" label="{{ trans_choice('general.payment_methods', 1) }}" :options="$payment_methods" :selected="old('payment_method', setting('payroll.payment_method'))" form-group-class="sm:col-span-3" />
                    </x-slot>
                </x-form.section>

                <div class="grid sm:grid-cols-6 mr-4">
                    <x-form.section class="sm:col-span-3 mb-14" override="class">
                        <x-slot name="head">
                            <x-form.section.head title="{{ trans_choice('payroll::general.benefits', 1) }}" description="" />
                        </x-slot>

                        <x-slot name="body">
                            <div class="sm:col-span-6">
                                @include('payroll::settings.benefit')
                            </div>
                        </x-slot>
                    </x-form.section>

                    <x-form.section class="sm:col-span-3 mb-14 sm:ml-4" override="class">
                        <x-slot name="head">
                            <x-form.section.head title="{{ trans_choice('payroll::general.deductions', 1) }}" description="" />
                        </x-slot>

                        <x-slot name="body">
                            <div class="sm:col-span-6">
                                @include('payroll::settings.deduction')
                            </div>
                        </x-slot>
                    </x-form.section>
                </div>

                @can('update-payroll-settings')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons :cancel="url()->previous()" />
                        </x-slot>
                    </x-form.section>
                @endcan
            </x-form>
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var benefit_pay_items = {!! json_encode($benefit_pay_items) !!};
            var deduction_pay_items = {!! json_encode($deduction_pay_items) !!};
        </script>
    @endpush

    <x-script alias="payroll" file="settings" />
</x-layouts.admin>


