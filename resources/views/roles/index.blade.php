@extends('layouts.app')

@section('title', 'الصلاحيات')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">الصلاحيات</h4>
        <p class="page-subtitle">إدارة أدوار وصلاحيات النظام</p>
    </div>
    @can('create roles')
    <a href="{{ route('roles.create') }}" class="btn-modern-primary">
        <i class="bi bi-plus-lg"></i> إضافة دور
    </a>
    @endcan
</div>
@can('view roles')
<div class="card border-0">
    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الدور</th>
                    <th>الصلاحيات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="table-user-cell">
                            <div class="table-user-icon" style="background: rgba(139,92,246,0.1); color: #8b5cf6;">
                                <i class="bi bi-shield"></i>
                            </div>
                            <span class="fw-bold">{{ $role->name }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @forelse($role->permissions as $permission)
                                <span class="perm-badge">{{ $permission->name }}</span>
                            @empty
                                <span class="text-muted">لا يوجد صلاحيات</span>
                            @endforelse
                        </div>
                    </td>
                    <td>
                        @can('edit roles')
                        <a href="{{ route('roles.edit', $role->id) }}" class="action-btn action-btn-edit " title="تعديل">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan
                        @can('delete roles')
                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                            class="d-inline mt-3" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-btn-delete" title="حذف">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-shield-lock"></i>
                            <p>لا يوجد أدوار مسجلة بعد</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endcan
@endsection