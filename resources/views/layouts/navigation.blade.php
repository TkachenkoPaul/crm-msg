<aside class="main-sidebar sidebar-dark-primary elevation-5">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .7">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user-icon.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('messages.index') }}" class="nav-link">
                        <i class="far fa-comments nav-icon"></i>
                        <p>Заявки</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-report.index') }}" class="nav-link">
                        <i class="far fa-chart-bar nav-icon"></i>
                        <p>Статистика</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs nav-icon"></i>
                        <p>
                            Настройки
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link ">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Пользователи</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('status.index') }}" class="nav-link">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Статусы</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('types.index') }}" class="nav-link">
                                <i class="fas fa-toolbox nav-icon"></i>
                                <p>Типы</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Выход</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
