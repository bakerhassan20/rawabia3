@extends('layouts.app')

@section('title', 'المستخدمين')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">المستخدمين</h4>
        <p class="page-subtitle">إدارة حسابات المستخدمين والصلاحيات</p>
    </div>
    @can('create users')
    <a href="{{ route('users.create') }}" class="btn-modern-primary">
        <i class="bi bi-plus-lg"></i> إضافة مستخدم
    </a>
    @endcan
</div>
@can('view users')
<div class="card border-0">
    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الصلاحيات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="table-user-cell">
                            <div class="table-user-icon">{{ mb_substr($user->name, 0, 1) }}</div>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @forelse($user->roles as $role)
                            <span class="role-badge">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">بدون صلاحية</span>
                        @endforelse
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            @can('edit users')
                            <a href="{{ route('users.edit', $user->id) }}" class="action-btn action-btn-edit" title="تعديل">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan
                            @can('delete users')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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
                    <td colspan="5" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>لا يوجد مستخدمين بعد</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links('vendor.pagination.bootstrap-5') }}
</div>
@endcan
@endsection