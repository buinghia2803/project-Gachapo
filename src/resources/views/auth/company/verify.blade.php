@extends('company.layouts.company_simple')
@section('title', 'ログイン')
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
                                <form action="{{ route('company.verify-code') }}" id="verify_form" method="POST">
                                    @csrf
                                    @include('company.components.form.text', [
                                        'name' => 'code',
                                        'value' => '',
                                        'labels' => 'コード',
                                        'placeholder' => '入力してください',
                                        'required' => true,
                                    ])
                                    <div class="row">
                                        <label class="col-12 col-md-4"></label>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary col-12 mb-3">{{__('labels.AUTH001_L001')}}</button>
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
        const errorMessageMaxLength = '{{ __('messages.CM001_L025', ['attr' => 50]) }}';
        validation('#verify_form', {
            'code': {
                required: true,
                maxlength: 50,
            },
        }, {
            'code': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength,
            },
        });
    </script>
@endsection
