<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex justify-content-between">
    <!-- Left navbar links -->
    <a href="{{ route('admin.admin') }}" class="brand-link title-page">
        <h3>Online Gacha</h3>
    </a>

    <ul class="navbar-nav">
        <li class="nav-item mr-5">
            <span class="nav-link h-notify text-overflow-ellipsis row-1">
                @if(\Auth::guard('admin')->check())
                    {{Auth::guard('admin')->user()->name}}
                @else
                @endif
            </span>
        </li>
        <li class="nav-item ml-auto">
            <a class="btn nav-link h-notify btn-white" href="{{ route('admin.notify.index') }}">
                {{__('labels.CDB001_L007')}}
            </a>
        </li>
    </ul>
</nav>
