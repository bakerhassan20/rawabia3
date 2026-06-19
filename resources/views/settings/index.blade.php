@extends('layouts.app')

@section('title', 'الإعدادات')

@section('content')

<div class="page-header">
    <div>
        <h4 class="page-title">إعدادات النظام</h4>
        <p class="page-subtitle">تخصيص إعدادات لوحة التحكم</p>
    </div>
</div>
@can('edit settings')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 p-4">
            <h5 class="form-section-title mb-4">
                <i class="bi bi-gear"></i> الإعدادات العامة
            </h5>

            @if(session('success'))
            <div class="alert-modern alert-success-modern mb-4">
                <i class="bi bi-check-circle-fill"></i>
                <span class="me-2">{{ session('success') }}</span>
            </div>
            @endif

          <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">اسم النظام</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-building input-icon"></i>
                        <input type="text" name="site_name"
                               value="{{ $settings->site_name ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="اسم النظام">
                    </div>
                </div>
                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">وصف النظام</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-building input-icon"></i>
                        <input type="text" name="site_description"
                               value="{{ $settings->site_description ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="وصف النظام">
                    </div>
                </div>

                 <div class="form-group-modern mb-4">
                    <label class="form-label-modern"> الشعار</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-image input-icon"></i>
                        <input type="file" name="logo"
                               value="{{ $settings->logo ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="الشعار">
                    </div>
                </div>
                <div class="form-group-modern mb-4">
                    <label class="form-label-modern"> Favicon</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-image input-icon"></i>
                        <input type="file" name="favicon"
                               value="{{ $settings->favicon ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="Favicon">
                    </div>
                </div>

              

                  <div class="form-group-modern mb-4">
                    <label class="form-label-modern"> العملة</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-coin input-icon"></i>
                        <input type="text" name="currency"
                               value="{{ $settings->currency ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="العملة">
                    </div>
                </div>

                <div class="form-group-modern mb-4">
                    <label class="form-label-modern">Footer text</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-file-earmark-text input-icon"></i>
                        <input type="text" name="footer_text"
                               value="{{ $settings->footer_text ?? '' }}"
                               class="form-control form-control-modern"
                               placeholder="Footer text">
                    </div>
                </div>


                <div class="form-group-modern mb-5">
                    <label class="form-label-modern mb-3">خيارات المظهر</label>
                    <div class="settings-toggle-card">
                        <div>
                            <strong>الوضع الداكن</strong>
                            <p class="text-muted mb-0" style="font-size: 12px;">تفعيل الوضع الداكن بشكل افتراضي</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="dark_mode" value="1"
                                   @if(session('dark_mode')) checked @endif>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-modern-primary ">
                    <i class="bi bi-check-lg"></i> حفظ الإعدادات
                </button>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection