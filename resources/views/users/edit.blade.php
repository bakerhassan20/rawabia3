@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">تعديل المستخدم</h4>
        <p class="page-subtitle">{{ $user->name }}</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn-modern-secondary">
        <i class="bi bi-arrow-right"></i> العودة للقائمة
    </a>
</div>
@can('edit users')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-pencil-square"></i> تعديل بيانات الحساب
            </h5>

            @if($errors->any())
            <div class="alert-modern alert-danger-modern mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 me-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">الاسم</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="form-control form-control-modern">
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">البريد الإلكتروني</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="form-control form-control-modern">
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">كلمة المرور الجديدة <span class="text-muted">(اتركها فارغة إذا لم تريد التغيير)</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password"
                               class="form-control form-control-modern" placeholder="••••••••">
                    </div>
                </div>

                <div class="form-group-modern mb-5">
                    <label class="form-label-modern mb-3">الصلاحيات</label>
                    <div class="roles-grid">
                        @foreach($roles as $role)
                        <label class="role-checkbox-card">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   @checked(in_array($role->name, $userRoles))>
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
                        <i class="bi bi-check-lg"></i> حفظ التعديلات
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-modern-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection