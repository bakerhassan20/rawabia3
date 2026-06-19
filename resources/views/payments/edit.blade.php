@extends('layouts.app')

@section('title', 'تعديل الدفعة')

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
@can('edit payments')
    <form method="POST" action="{{ route('payments.update', $payment->id) }}">

        @csrf
        @method('PUT')

        <div class="form-group-modern mb-4">

            <label class="form-label-modern">
                القسط <span class="text-danger">*</span>
            </label>

            <div class="input-icon-wrapper">

                <i class="bi bi-credit-card input-icon"></i>

                <select name="installment_id" class="form-control form-control-modern" required>

                    @foreach($installments as $installment)

                        <option value="{{ $installment->id }}" {{ old('installment_id', $payment->installment_id) == $installment->id ? 'selected' : '' }}>

                            {{ $installment->contract->client->name }}
                            -
                            {{ $installment->contract->car_name }}
                            -
                            قسط رقم {{ $installment->installment_number }}
                            -
                            {{ number_format($installment->amount, 2) }} ر.س

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <div class="form-group-modern mb-4">

            <label class="form-label-modern">
                قيمة الدفعة (ر.س)
                <span class="text-danger">*</span>
            </label>

            <div class="input-icon-wrapper">

                <i class="bi bi-wallet2 input-icon"></i>

                <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}"
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

                <input type="date" name="payment_date"
                    value="{{ old('payment_date', optional($payment->payment_date)->format('Y-m-d')) }}"
                    class="form-control form-control-modern" required>

            </div>

        </div>

        <div class="form-group-modern mb-5">

            <label class="form-label-modern">
                ملاحظات
            </label>

            <textarea name="notes" rows="3"
                class="form-control form-control-modern">{{ old('notes', $payment->notes) }}</textarea>

        </div>

        <div class="">

            <button type="submit" class="btn-modern-primary flex-grow-1">

                <i class="bi bi-check-lg"></i>
                حفظ التعديلات

            </button>

            <a href="{{ route('payments.index') }}" class="btn-modern-secondary">

                إلغاء

            </a>

        </div>
        @endcan
    </form>

@endsection