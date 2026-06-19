@extends('layouts.app')

@section('title', 'العملاء')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h4 class="page-title">العملاء</h4>
        <p class="page-subtitle">إدارة بيانات العملاء</p>
    </div>
    @can('create clients')
    <a href="{{ route('clients.create') }}" class="btn-modern-primary">
        <i class="bi bi-plus-lg"></i> إضافة عميل
    </a>
    @endcan
</div>
@can('view clients')

{{-- Search --}}
<div class="card p-4 mb-4 border-0">
    <form method="GET" class="d-flex gap-3 align-items-center">
        <div class="search-input-wrapper flex-grow-1">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="search" class="form-control search-input"
                   placeholder="ابحث باسم العميل أو رقم الهاتف..."
                   value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn-modern-primary">
            <i class="bi bi-search"></i> بحث
        </button>
        @if(request('search'))
            <a href="{{ route('clients.index') }}" class="btn-modern-secondary">
                <i class="bi bi-x-lg"></i> مسح
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
                    <th>الهاتف</th>
                    <th>البريد الإلكتروني</th>
                    <th>العنوان</th>
                    <th>السيارات</th>
                    <th>إجمالي العقود</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="table-user-cell">
                            <div class="table-user-icon">{{ mb_substr($client->name, 0, 1) }}</div>
                            <span class="fw-bold">{{ $client->name }}</span>
                        </div>
                    </td>
                    <td>{{ $client->phone }}</td>
                    <td class="text-muted">{{ $client->email }}</td>
                    <td class="text-muted">{{ $client->address ?? '—' }}</td>
                    <td>
                    {{ $client->contracts->count() }}
                    </td>

                    <td>
                        {{ number_format(
                            $client->contracts->sum('total_amount'),
                            0
                        ) }}
                       
                    </td>
                    <td>
                        <span class="status-badge {{ $client->status == 'active' ? 'status-active' : 'status-inactive' }}">
                            <span class="status-dot"></span>
                            {{ $client->status == 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            @can('edit clients')
                            <a href="{{ route('clients.edit', $client->id) }}" class="action-btn action-btn-edit" title="تعديل">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete clients')
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-btn-delete" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>لا يوجد عملاء مسجلين بعد</p>
                            <a href="{{ route('clients.create') }}" class="btn-modern-primary mt-2">إضافة أول عميل</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $clients->links('vendor.pagination.bootstrap-5') }}
</div>
@endcan

@endsection