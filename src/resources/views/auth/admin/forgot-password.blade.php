@extends('admin.layouts.admin_simple')
@section('title', __('labels.AUTH001_L005'))
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
                <a href="{{ route('admin.password.email') }}" class="brand-link title-page">
                    <h3>Online Gacha</h3>
                </a>
            </div>
            <div class="container-fluid">
                {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('labels.AUTH001_L005')}}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.password.email') }}" id="forgot_password_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @include('admin.components.form.text', [
                                        'name' => 'email',
                                        'value' => '',
                                        'labels' => __('labels.AUTH001_L006'),
                                        'placeholder' => __('labels.CM001_L008'),
                                        'required' => true,
                                    ])
                                    <div class="row">
                                        <label class="col-12 col-md-4"></label>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary col-12 mb-3">{{__('labels.CM001_L034')}}</button>
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
        validation('#forgot_password_form', {
            'email': {
                required: true,
                maxlength: 255,
                isValidEmail: true,
            },
        }, {
            'email': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength255,
                isValidEmail: errorMessageEmailWrongFomat,
            },
        });
    </script>
@endsection
