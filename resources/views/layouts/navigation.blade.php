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
                @can('view messages')
                    <li class="nav-item">
                        <a href="{{ route('messages.index') }}" class="nav-link">
                            <i class="far fa-comments nav-icon"></i>
                            <p>Заявки</p>
                        </a>
                    </li>
                @endcan
                @can('view reports')
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="far fa-file-archive nav-icon"></i>
                            <p>Отчеты</p>
                        </a>
                    </li>
                @endcan
                @can('view messages')
                    <li class="nav-item">
                        <a href="{{ route('appeals.index') }}" class="nav-link">
                            <i class="far fa-comment nav-icon"></i>
                            @if($appeals->count() > 0)
                                <span class="badge badge-success navbar-badge">{{ $appeals->count() }}</span>
                            @endif
                            <p>Обращения</p>
                        </a>
                    </li>
                @endcan
                {{--                @can('view roles')--}}
                {{--                    <li class="nav-item">--}}
                {{--                        <a href="{{ route('operations.index') }}" class="nav-link ">--}}
                {{--                            <i class="fas fa-tasks nav-icon"></i>--}}
                {{--                            <p>Операции</p>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endcan--}}
                @can('view statistic')
                    <li class="nav-item">
                        <a href="{{ route('user-report.index') }}" class="nav-link">
                            <i class="far fa-chart-bar nav-icon"></i>
                            <p>Статистика</p>
                        </a>
                    </li>
                @endcan

                @canany('view users|view roles|view types|view statuses')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cogs nav-icon"></i>
                            <p>
                                Настройки
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('view roles')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link ">
                                        <i class="fas fa-user-shield nav-icon"></i>
                                        <p>Роли</p>
                                    </a>
                                </li>
                            @endcan
                            @can('view users')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link ">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Пользователи</p>
                                    </a>
                                </li>
                            @endcan
                            @can('view statuses')
                                <li class="nav-item">
                                    <a href="{{ route('status.index') }}" class="nav-link">
                                        <i class="fas fa-tasks nav-icon"></i>
                                        <p>Статусы</p>
                                    </a>
                                </li>
                            @endcan
                            @can('view types')
                                <li class="nav-item">
                                    <a href="{{ route('types.index') }}" class="nav-link">
                                        <i class="fas fa-toolbox nav-icon"></i>
                                        <p>Типы</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
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
