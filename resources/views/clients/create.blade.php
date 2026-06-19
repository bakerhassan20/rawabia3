@extends('layouts.app')

@section('title', 'إضافة عميل')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">إضافة عميل جديد</h4>
        <p class="page-subtitle">أدخل بيانات العميل الجديد</p>
    </div>
    <a href="{{ route('clients.index') }}" class="btn-modern-secondary">
        <i class="bi bi-arrow-right"></i> العودة للقائمة
    </a>
</div>
@can('create clients')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-person-plus"></i> بيانات العميل
            </h5>

            @if($errors->any())
            <div class="alert-modern alert-danger-modern mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 me-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">الاسم الكامل <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control form-control-modern @error('name') is-invalid @enderror"
                               placeholder="مثال: أحمد محمد" required>
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">رقم الهاتف <span class="text-danger">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-phone input-icon"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="form-control form-control-modern @error('phone') is-invalid @enderror"
                               placeholder="01xxxxxxxxx" required>
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">البريد الإلكتروني</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control form-control-modern @error('email') is-invalid @enderror"
                               placeholder="example@email.com">
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">العنوان</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-geo-alt input-icon"></i>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="form-control form-control-modern"
                               placeholder="مثال: القاهرة، مصر الجديدة">
                    </div>
                </div>



                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">صورة الهوية</label>
                     <div class="input-icon-wrapper">
                         <i class="bi bi-file-earmark input-icon"></i>
                        <input type="file" name="identification_photo"
                                class="form-control form-control-modern">
                    </div>
                </div>

                <div class="form-group-modern mb-5">
                    <label class="form-label-modern">الحالة</label>
                    <select name="status" class="form-control form-control-modern">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ نشط</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>❌ غير نشط</option>
                    </select>
                </div>

                <div class="">
                    <button type="submit" class="btn-modern-primary flex-grow-1">
                        <i class="bi bi-check-lg"></i> حفظ العميل
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn-modern-secondary">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection