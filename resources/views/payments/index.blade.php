@extends('layouts.app')

@section('title', 'المدفوعات')

@section('content')

    <div class="page-header">
        <div>
            <h4 class="page-title">المدفوعات</h4>
            <p class="page-subtitle">سجل جميع دفعات الأقساط</p>
        </div>
        @can('create payments')
        <a href="{{ route('payments.create') }}" class="btn-modern-primary">
            <i class="bi bi-plus-lg"></i> إضافة دفعة
        </a>
        @endcan
    </div>
@can('view payments')
    {{-- Filter --}}
    <div class="card p-4 mb-4 border-0">
        <form method="GET" class="d-flex gap-3 align-items-center flex-wrap">
            <div class="input-icon-wrapper" style="width: 220px;">
                <i class="bi bi-funnel input-icon"></i>
                <select name="status" class="form-control form-control-modern" onchange="this.form.submit()">
                    <option value="">كل الحالات</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مسددة</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>جزئية</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>متأخرة</option>
                </select>
            </div>
            @if(request('status'))
                <a href="{{ route('payments.index') }}" class="btn-modern-secondary">
                    <i class="bi bi-x-lg"></i> مسح الفلتر
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="card border-0">
        <div class="table-responsive">
            <table class="table table-premium align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>السيارة</th>
                        <th>رقم القسط</th>
                        <th>قيمة الدفعة</th>
                        <th>تاريخ الدفع</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        @php
                            $statusMap = [
                                'paid' => ['label' => 'مسدد', 'class' => 'status-active'],
                                'partial' => ['label' => 'جزئي', 'class' => 'status-partial'],
                                'pending' => ['label' => 'متأخر', 'class' => 'status-inactive'],
                            ];
                            $s = $statusMap[$payment->status] ?? ['label' => $payment->status, 'class' => 'status-inactive'];
                        @endphp
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $payment->installment->contract->client->name }}
                            </td>

                            <td>
                                {{ $payment->installment->contract->car_name }}
                            </td>

                            <td>
                                {{ $payment->installment->installment_number }}
                            </td>

                            <td class="fw-bold text-success">
                                {{ number_format($payment->amount, 2) }}
                                ر.س
                            </td>

                            <td>
                                {{ $payment->payment_date }}
                            </td>

                            <td>

                                <div class="d-flex gap-2">
                                    @can('edit payments')
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="action-btn action-btn-edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>
                                    @endcan
                                    @can('delete payments')
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn action-btn-delete">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>
                                    @endcan

                                </div>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-cash-stack"></i>
                                    <p>لا يوجد دفعات مسجلة بعد</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endcan
@endsection