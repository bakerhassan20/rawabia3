@extends('layouts.app')

@section('title', 'إنشاء دور جديد')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">إنشاء دور جديد</h4>
        <p class="page-subtitle">تحديد الصلاحيات للدور</p>
    </div>
    <a href="{{ route('roles.index') }}" class="btn-modern-secondary">
        <i class="bi bi-arrow-right"></i> العودة للقائمة
    </a>
</div>
@can('create roles')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-shield-plus"></i> بيانات الدور
            </h5>

            @if($errors->any())
            <div class="alert-modern alert-danger-modern mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 me-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">اسم الدور <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-shield input-icon"></i>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control form-control-modern" placeholder="مثال: مدير، محاسب..." required>
                    </div>
                </div>

                <div class="form-group-modern mb-5">
                    <label class="form-label-modern mb-3">الصلاحيات</label>
                    <div class="roles-grid">
                        @foreach($permissions as $permission)
                        <label class="role-checkbox-card">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                            <div class="role-card-content">
                                <i class="bi bi-check2-circle"></i>
                                <span class="role-name">{{ $permission->description }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn-modern-primary flex-grow-1">
                        <i class="bi bi-check-lg"></i> إنشاء الدور
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn-modern-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection