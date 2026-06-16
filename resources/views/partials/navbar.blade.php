<div class="navbar">

    <div class="navbar-right">
        <button class="navbar-toggle-menu d-lg-none" id="sidebarToggleBtn">
            <i class="bi bi-list"></i>
        </button>
        <div class="navbar-user-info">
            <div class="navbar-user-avatar">
                {{ mb_substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="navbar-user-text">
                <h5 class="navbar-user-name">مرحباً، {{ auth()->user()->name }}</h5>
                <p class="navbar-user-role">
                    {{ auth()->user()->roles->first()->name ?? 'مدير النظام' }}
                </p>
            </div>
        </div>
    </div>

    <div class="navbar-left">

        <button id="toggleTheme" class="navbar-icon-btn">
            <i class="bi bi-moon"></i>
        </button>

        <div class="dropdown">
            <button class="navbar-icon-btn" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="navbar-badge">3</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-start">
                <li><span class="dropdown-header text-muted text-start">الإشعارات</span></li>
                <li><a class="dropdown-item text-start" href="#">تم إضافة عميل جديد اليوم</a></li>
                <li><a class="dropdown-item text-start" href="#">قسط مستحق على أحمد محمد</a></li>
                <li><a class="dropdown-item text-start" href="#">تحديث أمان للنظام</a></li>
            </ul>
        </div>

        <div class="dropdown">
            <button class="navbar-icon-btn" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-start">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        الملف الشخصي
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" style="width: 100%;">
                            تسجيل خروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</div>