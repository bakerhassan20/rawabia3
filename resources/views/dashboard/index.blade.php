@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')

    @can('view dashboard')
    <!-- KPI CARDS -->
    <div class="row g-4 mb-4">

        <!-- Card 1: إجمالي العملاء -->
        <div class="col-md-3">
            <div class="kpi-card kpi-card-blue">
                <div class="kpi-card-body">
                    <div class="kpi-card-info">
                        <h6>إجمالي العملاء</h6>
                        <h3>{{ $totalClients }} <span>عميل</span></h3>
                    </div>
                    <div class="kpi-card-icon-wrapper bg-blue-accent">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="kpi-card-footer">
                    <a href="{{ route('clients.index') }}">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: إجمالي العقود -->
        <div class="col-md-3">
            <div class="kpi-card kpi-card-green">
                <div class="kpi-card-body">
                    <div class="kpi-card-info">
                        <h6>إجمالي العقود</h6>
                        <h3>{{ $totalContracts }} <span>عقد</span></h3>
                    </div>
                    <div class="kpi-card-icon-wrapper bg-green-accent">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
                <div class="kpi-card-footer">
                    <a href="{{ route('contracts.index') }}">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: إجمالي المدفوع -->
        <div class="col-md-3">
            <div class="kpi-card kpi-card-orange">
                <div class="kpi-card-body">
                    <div class="kpi-card-info">
                        <h6>إجمالي المدفوع</h6>
                        <h3>{{ number_format($totalPaid) }} <span>ر.س</span></h3>
                    </div>
                    <div class="kpi-card-icon-wrapper bg-orange-accent">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="kpi-card-footer">
                    <a href="{{ route('payments.index') }}">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: المتبقي -->
        <div class="col-md-3">
            <div class="kpi-card kpi-card-purple">
                <div class="kpi-card-body">
                    <div class="kpi-card-info">
                        <h6>إجمالي المتبقي</h6>
                        <h3>{{ number_format($totalRemaining) }} <span>ر.س</span></h3>
                    </div>
                    <div class="kpi-card-icon-wrapper bg-purple-accent">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <div class="kpi-card-footer">
                    <a href="{{ route('contracts.index') }}">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-card-body">
                    <h6>الأقساط المدفوعة</h6>
                    <h3>{{ $paidInstallments }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-card-body">
                    <h6>الأقساط المعلقة</h6>
                    <h3>{{ $pendingInstallments }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-card-body">
                    <h6>الأقساط المتأخرة</h6>
                    <h3>{{ $overdueInstallments }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- CHARTS & OVERDUES -->
    <!-- Donut Chart Card -->

    <div class="row">

        <div class="col-lg-5">
            <div class="card h-100 p-4 border-0 text-start">


                <div class="d-flex justify-content-between align-items-center mb-4 ">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3 text-primary fs-5"></i>
                        <h5 class="mb-0">حالة الأقساط</h5>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-sm-6">
                        <div id="statusChart"></div>
                    </div>

                    <div class="col-sm-6">

                        @php

                            $totalCount = max(
                                $paidInstallments +
                                $pendingInstallments +
                                $overdueInstallments,
                                1
                            );

                            $paidPercent =
                                round(($paidInstallments / $totalCount) * 100);

                            $pendingPercent =
                                round(($pendingInstallments / $totalCount) * 100);

                            $overduePercent =
                                round(($overdueInstallments / $totalCount) * 100);

                        @endphp

                        <div class="donut-legend">

                            <div class="donut-legend-item">
                                <div class="donut-legend-label">
                                    <span class="donut-legend-dot bg-success"></span>
                                    <span>مدفوعة</span>
                                </div>

                                <div class="donut-legend-value">
                                    <span>{{ $paidInstallments }}</span>
                                    <span class="donut-legend-percent">
                                        ({{ $paidPercent }}%)
                                    </span>
                                </div>
                            </div>

                            <div class="donut-legend-item">
                                <div class="donut-legend-label">
                                    <span class="donut-legend-dot bg-warning"></span>
                                    <span>معلقة</span>
                                </div>

                                <div class="donut-legend-value">
                                    <span>{{ $pendingInstallments }}</span>
                                    <span class="donut-legend-percent">
                                        ({{ $pendingPercent }}%)
                                    </span>
                                </div>
                            </div>

                            <div class="donut-legend-item">
                                <div class="donut-legend-label">
                                    <span class="donut-legend-dot bg-danger"></span>
                                    <span>متأخرة</span>
                                </div>

                                <div class="donut-legend-value">
                                    <span>{{ $overdueInstallments }}</span>
                                    <span class="donut-legend-percent">
                                        ({{ $overduePercent }}%)
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>



            </div>


        </div>

        <!-- Latest Overdues Card -->

        <div class="col-lg-7">
            <div class="card h-100 p-4 border-0 text-start">

                <div class="d-flex justify-content-between align-items-center mb-4 ">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-circle text-danger fs-5"></i>
                        <h5 class="mb-0">الأقساط المتأخرة</h5>
                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table table-premium align-middle">

                        <thead>
                            <tr>
                                <th>العميل</th>
                                <th>السيارة</th>
                                <th>رقم القسط</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>القيمة</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($latestOverdues as $installment)

                                <tr>

                                    <td>
                                        {{ $installment->contract->client->name }}
                                    </td>

                                    <td>
                                        {{ $installment->contract->car_name }}
                                    </td>

                                    <td>
                                        {{ $installment->installment_number }}
                                    </td>

                                    <td class="text-danger fw-bold">
                                        {{ $installment->due_date }}
                                    </td>

                                    <td class="text-danger fw-bold">
                                        {{ number_format($installment->amount) }} ر.س
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">

                                        لا توجد أقساط متأخرة حالياً

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="footer-link-container px-0 pb-0 mt-3">
                    <a href="{{ route('contracts.index') }}" class="footer-link-btn">

                        عرض العقود
                        <i class="bi bi-arrow-left"></i>

                    </a>
                </div>

            </div>


        </div>

    </div>
    <!-- LATEST PAYMENTS TABLE -->
    <div class="row g-4 mb-4 mt-5">
        <div class="col-12">
            <div class="card p-4 border-0 text-start">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0">أحدث الدفعات</h5>
                        <i class="bi bi-receipt text-success fs-5"></i>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-premium align-middle">
                        <thead>
                            <tr>
                                <th>العميل</th>
                                <th>السيارة</th>
                                <th>رقم العقد</th>
                                <th>رقم القسط</th>
                                <th>تاريخ الدفع</th>
                                <th>المبلغ</th>
                                <th>الشهر</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($latestPayments as $payment)

                                @php

                                    $months = [
                                        1 => 'يناير',
                                        2 => 'فبراير',
                                        3 => 'مارس',
                                        4 => 'أبريل',
                                        5 => 'مايو',
                                        6 => 'يونيو',
                                        7 => 'يوليو',
                                        8 => 'أغسطس',
                                        9 => 'سبتمبر',
                                        10 => 'أكتوبر',
                                        11 => 'نوفمبر',
                                        12 => 'ديسمبر'
                                    ];

                                    $monthNum = date(
                                        'n',
                                        strtotime($payment->payment_date)
                                    );

                                    $year = date(
                                        'Y',
                                        strtotime($payment->payment_date)
                                    );

                                    $monthName =
                                        ($months[$monthNum] ?? '') .
                                        ' ' .
                                        $year;

                                @endphp

                                <tr>

                                    <td>
                                        <div class="table-user-cell">
                                            <div class="table-user-icon">
                                                <i class="bi bi-person"></i>
                                            </div>

                                            <span>
                                                {{ $payment->installment->contract->client->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="table-car-text">
                                            {{ $payment->installment->contract->car_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            #{{ $payment->installment->contract->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $payment->installment->installment_number }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $payment->payment_date }}
                                    </td>

                                    <td class="text-success fw-bold">
                                        {{ number_format($payment->amount) }} ر.س
                                    </td>

                                    <td>
                                        {{ $monthName }}
                                    </td>

                                    <td>
                                        <a href="{{ route('payments.edit', $payment->id) }}"
                                            class="btn btn-sm btn-outline-primary">

                                            تعديل

                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">

                                        لا يوجد دفعات مسجلة حالياً

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>



                <div class="footer-link-container px-0 pb-0 mt-3">
                    <a href="{{ route('payments.index') }}" class="footer-link-btn">
                        عرض كل الدفعات <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endcan

@endsection
@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>

        new ApexCharts(document.querySelector("#statusChart"), {

            chart: {
                type: 'donut',
                height: 200,
                toolbar: {
                    show: false
                }
            },

            series: [
            {{ $paidInstallments }},
            {{ $pendingInstallments }},
                {{ $overdueInstallments }}
            ],

            labels: [
                'مدفوعة',
                'معلقة',
                'متأخرة'
            ],

            colors: [
                '#10b981',
                '#f59e0b',
                '#ef4444'
            ],

            dataLabels: {
                enabled: false
            },

            legend: {
                show: false
            },

            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {

                            show: true,

                            total: {
                                show: true,
                                label: 'إجمالي الأقساط',
                                fontFamily: 'Cairo',
                                fontSize: '11px',
                                color: '#64748b',

                                formatter: function () {
                                    return '{{ $paidInstallments + $pendingInstallments + $overdueInstallments }}';
                                }
                            },

                            value: {
                                show: true,
                                fontFamily: 'Cairo',
                                fontSize: '16px',
                                fontWeight: '700',
                                color: 'var(--text-primary)',

                                formatter: function (val) {
                                    return val;
                                }
                            }

                        }
                    }
                }
            }

        }).render();

    </script>


@endpush