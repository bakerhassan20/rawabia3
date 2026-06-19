@extends('layouts.app')

@section('title', 'تفاصيل العقد')

@section('content')
@can('view contracts')
<div class="page-header">
    <div>
        <h4 class="page-title">
            {{ $contract->client->name }}
        </h4>

        <p class="page-subtitle">
            {{ $contract->car_name }}
        </p>
    </div>
</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card p-3">
            <h6>سعر السيارة</h6>
            <h4>
                {{ number_format($contract->car_price,2) }}
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>الفائدة</h6>
            <h4>
                {{ number_format($contract->interest_value,2) }}
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>المدفوع</h6>
            <h4>
                {{ number_format($contract->paid_amount,2) }}
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>المتبقي</h6>
            <h4>
                {{ number_format($contract->remaining_amount,2) }}
            </h4>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header">
        جدول الأقساط
    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th>رقم القسط</th>
                    <th>القيمة</th>
                    <th>الاستحقاق</th>
                    <th>الحالة</th>
                </tr>
            </thead>

            <tbody>

            @foreach($contract->installments as $installment)

                <tr>

                    <td>
                        {{ $installment->installment_number }}
                    </td>

                    <td>
                        {{ number_format($installment->amount,2) }}
                    </td>

                    <td>
                        {{ $installment->due_date->format('Y-m-d') }}
                    </td>

                    <td>

                        @if($installment->status == 'paid')

                            <span class="badge bg-success">
                                مدفوع
                            </span>

                        @elseif($installment->status == 'overdue')

                            <span class="badge bg-danger">
                                متأخر
                            </span>

                        @else

                            <span class="badge bg-warning">
                                انتظار
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>
@endcan
@endsection