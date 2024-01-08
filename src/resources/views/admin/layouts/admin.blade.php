<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="icon" href="#" type="image/x-icon">
    <link rel="stylesheet prefetch" href="{{asset(mix('css/datepicker.css'))}}">
    <link href="{{asset(mix('css/bootstrap-datetimepicker.min.css'))}}" rel="stylesheet">
    <title>@yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="@">
    <meta property="og:type" content="website">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="Waccha!">
    <meta property="og:image" content="">
    <meta property="og:image:secure_url" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    @yield('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/admin.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/jquery.datetimepicker.min.css'))}}">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

</head>
<body class="admin {{ !empty($bodyClass) ? $bodyClass : '' }}">
<div class="wrap">
    @include('admin.layouts._header')
    <div class="main-content">
        @include('admin.layouts._sidebar')
        <div class="content">
            @yield('content')
        </div>
    </div>
    @include('admin.layouts._footer')
</div>
@yield('before-scripts')
<script src="{{ url(mix('js/jquery.min.js')) }}"></script>
<script src="{{ url(mix('js/app.min.js')) }}"></script>
<script src="{{ url(mix('js/bootstrap.min.js')) }}"></script>
<script src="{{ url(mix('js/jquery.validate.min.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="{{ url(mix('js/admin.js')) }}"></script>
<script src="{{ url(mix('js/moment/moment.min.js')) }}"></script>
<script src="{{ url(mix('js/moment/moment-timezone.min.js')) }}"></script>
<script src="{{ url(mix('js/lodash/lodash.min.js')) }}"></script>

<script src="{{ url(mix('js/select2.min.js')) }}"></script>

<script src="{{url(mix('js/bootstrap-datepicker.js'))}}"></script>
<script src="{{url(mix('js/bootstrap-datetimepicker.min.js'))}}"></script>
<script src="{{url(mix('js/datepicker.ja.min.js'))}}"></script>
<script src="{{url(mix('js/jquery.datetimepicker.full.min.js'))}}"></script>
<script src="{{ asset('js/admin/functions.js') }}"></script>
@yield('javascript')
@yield('after-scripts')
</body>
</html>

