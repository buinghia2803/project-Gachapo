@extends('company.layouts.company_simple')
@section('title', __('labels.AUTH001_L007'))
@section('content')

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light d-block">
    <!-- Left navbar links -->
    <a href="{{ route('home') }}" class="brand-link title-page">
        <h3>Online Gacha</h3>
    </a>
</nav>

<div class="content">
    <div class="row m-0 p-3">
        <div class="col-12 col-md-2"></div>
        <div class="col-12 col-md-8 content-wrapper m-0 p-0">
            <div class="main-header text-center mt-3 mt-md-5 mb-3">
                <a href="{{ route('home') }}" class="brand-link title-page">
                    <h3>Online Gacha</h3>
                </a>
            </div>
            <div class="container-fluid">
                {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('labels.AUTH001_L007')}}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('company.password.update', $token) }}" id="reset_password_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    @include('admin.components.form.password', [
                                        'name' => 'password',
                                        'value' => '',
                                        'labels' => __('labels.CM001_L019'),
                                        'placeholder' => __('labels.CM001_L008'),
                                        'required' => true,
                                    ])

                                    @include('admin.components.form.password', [
                                        'name' => 'password_confirmation',
                                        'value' => '',
                                        'labels' => __('labels.AUTH001_L009'),
                                        'placeholder' => __('labels.CM001_L008'),
                                        'required' => true,
                                    ])

                                    <div class="row">
                                        <label class="col-12 col-md-4"></label>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary col-12 mb-3">{{__('labels.AUTH001_L010')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessagePasswordWrongFomat = '{{ __('messages.CM001_L023') }}';
        const errorMessagePasswordConfirmNotEqual = '{{ __('messages.CM001_L024') }}';
        validation('#reset_password_form', {
            'password': {
                required: true,
                minlength : 8,
                maxlength : 32,
                isValidPassword: true
            },
            'password_confirmation': {
                required: true,
                equalTo: '#password',
            },
        }, {
            'password': {
                required: errorMessageRequired,
                minlength: errorMessagePasswordWrongFomat,
                maxlength: errorMessagePasswordWrongFomat,
                isValidPassword: errorMessagePasswordWrongFomat,
            },
            'password_confirmation': {
                required: errorMessageRequired,
                equalTo: errorMessagePasswordConfirmNotEqual,
            },
        });
    </script>
@endsection
