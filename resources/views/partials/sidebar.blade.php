<div class="sidebar" id="sidebar">

    <div>
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">
                @if($settings->logo)
                <img src="{{ asset('uploads/settings/' . $settings->logo) }}" class="rounded-circle" style="width: 50px; height: 50px;" alt="">
                @endif
            </div>
            <div class="logo-text">
                <h4>{{ $settings->site_name ?? '' }}</h4>
                <small>{{ $settings->site_description ?? '' }}</small>
            </div>
        </a>

        <!-- Menu -->
        <ul>
            @can('view dashboard')
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> الرئيسية
                </a>
            </li>
            @endcan
            @can('view clients')
            <li>
                <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> العملاء
                </a>
            </li>
            @endcan

            @can('view contracts')
            <li>
                <a href="{{ route('contracts.index') }}" class="{{ request()->routeIs('contracts.*') ? 'active' : '' }}">
                    <i class="bi bi-file-text"></i> العقود
                </a>
            </li>
            @endcan

            @can('view payments')
            <li>
                <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> المدفوعات
                </a>
            </li>
            @endcan

            @can('view users')
            <li>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> المستخدمين
                </a>
            </li>
            @endcan

            @can('view roles')
            <li>
                <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i> الصلاحيات
                </a>
            </li>
            @endcan

            @can('view settings')
            <li>
                <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> الإعدادات
                </a>
            </li>
            @endcan
        </ul>
    </div>

    <div class="sidebar-bottom">
        <a href="{{ route('clients.create') }}" class="btn-sidebar-add-client">
            <i class="bi bi-plus-lg"></i> إضافة عميل جديد
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar-logout-btn">
                <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
            </button>
        </form>
    </div>

</div>