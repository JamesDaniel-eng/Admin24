<x-form.container class="relative lg:w-full z-10" override="class">
    <x-form id="run-payroll" :route="['payroll.pay-calendars.run-payrolls.attachments.update', $payCalendar->id, $runPayroll->id]">
        <x-form.group.file
            name="attachment"
            label="{{ trans('general.attachment') }}"
            singleWidthClasses
            not-required
            dropzone-class="w-100"
            multiple="multiple"
            :options="['acceptedFiles' => $file_types]"
            :value="!empty($runPayroll) ? $runPayroll->attachment : null"
            form-group-class="sm:col-span-6"
        />

        <x-form.section>
            <x-slot name="foot">
                <div class="flex justify-end mt-4">
                    <x-button
                        type="submit"
                        class="relative flex items-center content-end bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                        ::disabled="form.loading"
                        override="class"
                    >
                        <i v-if="form.loading" class="submit-spin absolute w-3 h-3 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                        <span :class="[{'opacity-0': form.loading}]">
                            {{ trans('general.save') }}
                        </span>
                    </x-button>
                </div>
            </x-slot>
        </x-form.section>
    </x-form>
</x-form.container>
