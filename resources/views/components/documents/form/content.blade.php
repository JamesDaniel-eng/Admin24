<x-loading.content />

<div class="relative mt-4">
    <x-form 
        id="{{ $formId }}"
        :route="$formRoute"
        method="{{ $formMethod }}"
        :model="$document"
    >
        @if (! $hideCompany)
            <x-documents.form.company :type="$type" />
        @endif

        <x-documents.form.main type="{{ $type }}" />

        @if ($showRecurring)
            <x-documents.form.recurring type="{{ $type }}" />
        @endif

        @if (! $hideAdvanced)
            <x-documents.form.advanced type="{{ $type }}" />
        @endif

        <x-form.input.hidden name="type" :value="old('type', $type)" />
        <x-form.input.hidden name="status" :value="old('status', $status)" />
        <x-form.input.hidden name="amount" :value="old('amount', '0')" />
        <x-form.input.hidden name="issued_at" :value="old('issued_at', $issuedAt)" />
        <x-form.input.hidden name="due_at" :value="old('due_at', $dueAt)" />
        <x-form.input.hidden name="currency_code" :value="old('currency_code', $currency_code)" />

        @if (! $hideButtons)
            <x-documents.form.buttons :type="$type" />
        @endif
    </x-form>
</div>
