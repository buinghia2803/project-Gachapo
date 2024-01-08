<div>
<!-- Main Sidebar Container -->
<button class="navbar-toggler main-navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <i class="fa fa-bars" aria-hidden="true"></i>
</button>
<aside class="main-sidebar sidebar-dark-primary elevation-4 collapse navbar-collapse" id="collapsibleNavbar">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="m-0">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ Request::routeIs('company.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('company.dashboard') }}" class="nav-link">{{__('labels.CDB001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('company.notify.*') ? 'active' : '' }}">
                    <a href="{{ route('company.notify.index') }}" class="nav-link">{{__('labels.CNL001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('company.gachas.*') ? 'active' : '' }}">
                    <a href="{{ route('company.gachas.index') }}" class="nav-link">{{__('labels.CDB001_L002')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('company.analytics.*') ? 'active' : '' }}">
                    <a href="{{ route('company.analytics.index') }}" class="nav-link">{{__('labels.ANLT001_L001')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('company.delivery.index')}}" class="nav-link">{{__('labels.CDB001_L004')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('company.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('company.profile') }}" class="nav-link">{{__('labels.CDB001_L005')}}</a>
                </li>
                <li class="nav-item">
                    <form method="post" action="{{ route('company.logout') }}" id="logout">
                        @csrf
                        <a href="javascript:void(0);" onclick="document.getElementById('logout').submit();" class="nav-link">{{__('labels.AUTH001_L004')}}</a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
</div>
