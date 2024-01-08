@extends('company.layouts.company_simple')
@section('title', __('labels.AUTH001_L001'))
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
                                <h3 class="card-title">{{__('labels.AUTH001_L001')}}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('company.login.submit') }}" id="login_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @error('account')
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">
                                                </label>
                                                <div class="col-12 col-md-8">
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    @enderror
                                    @include('company.components.form.text', [
                                        'name' => 'email',
                                        'value' => '',
                                        'labels' => __('labels.CM001_L030'),
                                        'placeholder' => __('labels.CM001_L030'),
                                        'required' => true,
                                    ])
                                    @include('company.components.form.password', [
                                        'name' => 'password',
                                        'value' => '',
                                        'labels' => __('labels.CM001_L019'),
                                        'placeholder' => __('labels.CM001_L008'),
                                        'required' => true,
                                    ])
                                    <div class="row">
                                        <label class="col-12 col-md-4"></label>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary col-12 mb-3">{{__('labels.AUTH001_L001')}}</button>
                                            <a href="{{route('company.password.forgot')}}" class="btn btn-default col-12" style="min-width: max-content;">{{__('labels.AUTH001_L003')}}</a>
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
        const errorMessageMaxLength255 = '{{ __('messages.CM001_L025', ['attr' => 255]) }}';
        const errorMessageEmailWrongFomat = '{{ __('messages.CM001_L018') }}';
        const errorMessagePasswordWrongFomat = '{{ __('messages.CM001_L023') }}';
        validation('#login_form', {
            'email': {
                required: true,
                maxlength: 255,
                isValidEmail: true,
            },
            'password': {
                required: true,
                minlength : 8,
                maxlength : 32,
                isValidPassword: true
            },
        }, {
            'email': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength255,
                isValidEmail: errorMessageEmailWrongFomat,
            },
            'password': {
                required: errorMessageRequired,
                minlength: errorMessagePasswordWrongFomat,
                maxlength: errorMessagePasswordWrongFomat,
                isValidPassword: errorMessagePasswordWrongFomat,
            },
        });
    </script>
@endsection
