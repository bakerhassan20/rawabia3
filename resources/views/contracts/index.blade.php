@extends('layouts.app')

@section('title', 'العقود')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">العقود</h4>
        <p class="page-subtitle">إدارة عقود السيارات</p>
    </div>


@can('create contracts')
<a href="{{ route('contracts.create') }}" class="btn-modern-primary">
    <i class="bi bi-plus-lg"></i>
    إضافة عقد
</a>
@endcan

</div>
@can('view contracts')
<div class="card border-0">
    <div class="table-responsive">

    <table class="table table-premium align-middle mb-0">

        <thead>
            <tr>
                <th>#</th>
                <th>العميل</th>
                <th>السيارة</th>
                <th>الإجمالي</th>
                <th>عدد الأقساط</th>
                <th>قيمة القسط</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>

        <tbody>

        @forelse($contracts as $contract)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $contract->client->name }}
                </td>

                <td>
                    {{ $contract->car_name }}
                </td>

                <td>
                    {{ number_format($contract->total_amount,2) }}
                </td>

                <td>
                    {{ $contract->installments_count }}
                </td>

                <td>
                    {{ number_format($contract->installment_amount,2) }}
                </td>

                <td>

                    <span class="status-badge status-active">
                        {{ $contract->status }}
                    </span>

                </td>

                <td>

                    <div class="d-flex gap-2">
@can('view contracts')
                        <a href="{{ route('contracts.show',$contract->id) }}"
                           class="action-btn">

                            <i class="bi bi-eye"></i>

                        </a>
@endcan
@can('edit contracts')

                        <a href="{{ route('contracts.edit',$contract->id) }}"
                           class="action-btn action-btn-edit">

                            <i class="bi bi-pencil"></i>

                        </a>
@endcan
@can('delete contracts')
                        <form method="POST"
                              action="{{ route('contracts.destroy',$contract->id) }}">

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
                    لا توجد عقود
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

{{ $contracts->links() }}


</div>
@endcan
@endsection
