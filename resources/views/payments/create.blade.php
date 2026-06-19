@extends('layouts.app')

@section('title', 'تسجيل دفعة')

@section('content')

    @if($errors->any())
        <div class="alert-modern alert-danger-modern mb-4">
            <i class="bi bi-exclamation-circle-fill"></i>
            <ul class="mb-0 me-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@can('create payments')
    <form method="POST" action="{{ route('payments.store') }}">
        @csrf

        <div class="form-group-modern mb-4">

            <label class="form-label-modern">
                العقد
                <span class="text-danger">*</span>
            </label>

            <select id="contract_id"  name="contract_id"  class="form-control form-control-modern">

                <option value="">
                    اختر العقد
                </option>

                @foreach($contracts as $contract)

                    <option value="{{ $contract->id }}">

                        {{ $contract->client->name }}
                        -
                        {{ $contract->car_name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group-modern mb-4">

            <label class="form-label-modern">
                القسط
                <span class="text-danger">*</span>
            </label>

            <select name="installment_id" id="installment_id" class="form-control form-control-modern" required>

                <option value="">
                    اختر القسط
                </option>

            </select>

        </div>

        <div class="form-group-modern mb-4">
            <label class="form-label-modern">
                قيمة الدفعة
                <span class="text-danger">*</span>
            </label>

            <div class="input-icon-wrapper">
                <i class="bi bi-wallet2 input-icon"></i>

                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                    class="form-control form-control-modern" required>
            </div>
        </div>

        <div class="form-group-modern mb-4">
            <label class="form-label-modern">
                تاريخ الدفع
                <span class="text-danger">*</span>
            </label>

            <div class="input-icon-wrapper">
                <i class="bi bi-calendar3 input-icon"></i>

                <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}"
                    class="form-control form-control-modern" required>
            </div>
        </div>

        {{-- add readonly to remaining_amount --}}
<div class="form-group-modern mb-4">
    <label class="form-label-modern">المتبقي بعد الدفع</label>

    <div class="input-icon-wrapper">
        <i class="bi bi-wallet2 input-icon"></i>

        <input type="text"
               id="remaining_amount"
               class="form-control form-control-modern"
               readonly>
    </div>
</div>

        <div class="form-group-modern mb-5">
            <label class="form-label-modern">
                ملاحظات
            </label>

            <textarea name="notes" rows="3" class="form-control form-control-modern">{{ old('notes') }}</textarea>
        </div>

        <div>
            <button type="submit" class="btn-modern-primary">
                <i class="bi bi-check-lg"></i>
                حفظ الدفعة
            </button>

            <a href="{{ route('payments.index') }}" class="btn-modern-secondary">
                إلغاء
            </a>
        </div>

    </form>
    @endcan
@endsection

@push('scripts')

    <script>

let installmentsData = [];

document.getElementById('contract_id').addEventListener('change', function () {

    let contractId = this.value;
    let installmentSelect = document.getElementById('installment_id');

    installmentSelect.innerHTML = '<option>جاري التحميل...</option>';

    if (!contractId) {
        installmentSelect.innerHTML = '<option value="">اختر القسط</option>';
        return;
    }

    fetch(`/contracts/${contractId}/installments`)
        .then(res => res.json())
        .then(data => {

            installmentsData = data;

            installmentSelect.innerHTML = '<option value="">اختر القسط</option>';

            data.forEach(item => {
                installmentSelect.innerHTML += `
                    <option value="${item.id}">
                        قسط رقم ${item.installment_number}
                        - المتبقي ${item.remaining} ر.س
                    </option>
                `;
            });
        });
});

document.getElementById('installment_id').addEventListener('change', function () {

    let selectedId = this.value;
    let amountInput = document.querySelector('input[name="amount"]');
    let remainingInput = document.querySelector('input[name="remaining_amount"]');

    let installment = installmentsData.find(i => i.id == selectedId);

    if (!installment) {
        remainingInput.value = '';
        return;
    }

    let remaining = installment.remaining;

    remainingInput.value = remaining.toFixed(2);

    // optional: منع إدخال مبلغ أكبر من المتبقي
    amountInput.setAttribute('max', remaining);
});

</script>
<script>

let currentRemaining = 0;

document.getElementById('installment_id').addEventListener('change', function () {

    let selectedId = this.value;

    let installment = installmentsData.find(i => i.id == selectedId);

    if (!installment) return;

    currentRemaining = parseFloat(installment.remaining);

    document.getElementById('remaining_amount').value =
        currentRemaining.toFixed(2);
});


document.querySelector('input[name="amount"]').addEventListener('input', function () {

    let entered = parseFloat(this.value) || 0;

    let newRemaining = currentRemaining - entered;

    if (newRemaining < 0) {
        newRemaining = 0;
    }

    document.getElementById('remaining_amount').value =
        newRemaining.toFixed(2);
});

</script>
@endpush