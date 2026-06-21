@extends('layouts.app')

@section('title', 'تعديل الدور')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">تعديل الدور</h4>
        <p class="page-subtitle">{{ $role->name }}</p>
    </div>
    <a href="{{ route('roles.index') }}" class="btn-modern-secondary">
        <i class="bi bi-arrow-right"></i> العودة للقائمة
    </a>
</div>
@can('edit roles')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-shield-check"></i> تعديل بيانات الدور
            </h5>

            @if($errors->any())
            <div class="alert-modern alert-danger-modern mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 me-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">اسم الدور</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-shield input-icon"></i>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                               class="form-control form-control-modern">
                    </div>
                </div>

                <div class="form-group-modern mb-5">
                    <label class="form-label-modern mb-3">الصلاحيات</label>
                    <div class="roles-grid">
                        @foreach($permissions as $permission)
                        <label class="role-checkbox-card">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   @checked(in_array($permission->name, $rolePermissions))>
                            <div class="role-card-content">
                                <i class="bi bi-check2-circle"></i>
                                <span>{{ $permission->description }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-modern-primary flex-grow-1">
                        <i class="bi bi-check-lg"></i> حفظ التعديلات
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn-modern-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endcan
@endsection