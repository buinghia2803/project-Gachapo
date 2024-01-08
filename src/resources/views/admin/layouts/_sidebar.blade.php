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
                <li class="nav-item {{ Request::routeIs('admin.admin') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin') }}" class="nav-link">{{__('labels.CDB001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.admin_users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin_users.index') }}" class="nav-link">{{__('labels.ADM001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.notify.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.notify.index') }}" class="nav-link">{{__('labels.NML001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.user.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.index') }}" class="nav-link">{{ __('labels.AUM001_L001') }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.company.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.company.index') }}" class="nav-link">{{__('labels.COL001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.company-application.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.company-application.index') }}" class="nav-link">{{__('labels.ACA001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.gachas.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.gachas.index') }}" class="nav-link">{{ __('labels.GAC001_L001') }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.delivery.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.delivery.index') }}" class="nav-link">{{ __("labels.ADEL001_L001") }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.banner-main-visuals.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banner-main-visuals.index') }}" class="nav-link">{{ __('labels.BMV001_L001') }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.banners.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banners.index') }}" class="nav-link">{{ __('labels.BNN001_L001') }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.pages.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link">{{ __('labels.APM001_L001') }}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.analytics.index') }}" class="nav-link">{{__('labels.ANLT001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.category.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.index') }}" class="nav-link">{{__('labels.AC001_L001')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.coupon.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupon.index') }}" class="nav-link">{{__('labels.ACPL001_L003')}}</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.mail-templates.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.mail-templates.index') }}" class="nav-link">{{__('labels.AMT001_L001')}}</a>
                </li>
                <li class="nav-item">
                    <form method="post" action="{{ route('admin.logout') }}" id="logout">
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
