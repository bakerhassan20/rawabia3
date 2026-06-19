@extends('layouts.app')

@section('title', 'إضافة مستخدم')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">إضافة مستخدم جديد</h4>
        <p class="page-subtitle">إنشاء حساب مستخدم جديد</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn-modern-secondary">
        <i class="bi bi-arrow-right"></i> العودة للقائمة
    </a>
</div>
@can('create users')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-person-plus"></i> بيانات الحساب
            </h5>

            @if($errors->any())
            <div class="alert-modern alert-danger-modern mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 me-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">الاسم <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control form-control-modern" placeholder="الاسم الكامل" required>
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">البريد الإلكتروني <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control form-control-modern" placeholder="example@email.com" required>
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">كلمة المرور <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password"
                               class="form-control form-control-modern" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-group-modern mb-5">
                    <label class="form-label-modern mb-3">الصلاحيات</label>
                    <div class="roles-grid">
                        @foreach($roles as $role)
                        <label class="role-checkbox-card">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                            <div class="role-card-content">
                                <i class="bi bi-shield-check"></i>
                                <span>{{ $role->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn-modern-primary flex-grow-1">
                        <i class="bi bi-check-lg"></i> إنشاء الحساب
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-modern-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection