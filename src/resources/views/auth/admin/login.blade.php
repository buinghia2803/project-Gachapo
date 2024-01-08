@extends('admin.layouts.admin_simple')
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
                                <form action="{{ route('admin.login.submit') }}" id="login_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="name" class="col-12 col-md-4">
                                                    {{ __('labels.ADM001_L007') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-12 col-md-8">
                                                    <input
                                                        style="max-width: 500px;"
                                                        type="text"
                                                        name="email"
                                                        class="form-control"
                                                        id="email"
                                                        placeholder="{{ __('labels.CM001_L008') }}"
                                                        value="{{ old('email') }}"
                                                    >
                                                    @error('email') <div class="error-valid">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="name" class="col-12 col-md-4">
                                                    {{ __('labels.CM001_L019') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-12 col-md-8">
                                                    <input
                                                        style="max-width: 500px;"
                                                        type="password"
                                                        name="password"
                                                        class="form-control"
                                                        id="password"
                                                        placeholder="{{ __('labels.CM001_L008') }}"
                                                        value="{{ old('password') }}"
                                                    >
                                                    @error('password') <div class="error-valid">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-10 m-0">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary mb-3 w-25">{{__('labels.AUTH001_L001')}}</button>
                                                </div>
                                                <a href="{{ route('admin.password.request') }}" style="min-width: max-content;" class="btn btn-default">{{__('labels.AUTH001_L003')}}</a>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-2">
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
