@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CM001_L019') }}</a></li>
                <li><span>{{ __('labels.CM001_L019') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L019') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('company.profile.update.password') }}" id="create_company_form"
                            method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="password"
                                                class="col-12 col-md-4">{{ __('labels.CM001_L019') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="password" name="password" class="form-control" id="password"
                                                    placeholder="{{ __('labels.CM001_L019') }}">
                                                @error('password')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="password_confirmation"
                                                class="col-12 col-md-4">{{ __('labels.CM001_L020') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    id="password_confirmation" placeholder="{{ __('labels.CM001_L020') }}）">
                                                @error('password_confirmation')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4"></label>
                                            <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ __('labels.CM001_L044') }}</button>
                                                <a href="{{ route('company.profile') }}"
                                                    class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L017') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageConfirmPasswordNotEqual = '{{ __('messages.CM001_L024') }}';
        const errorMessagePasswordInvalid = '{{ __('messages.CM001_L023') }}';

        validation('#create_company_form', {
            'password': {
                minlength: 8,
                maxlength: 32,
                isValidPassword: true
            },
            'password_confirmation': {
                minlength: 8,
                maxlength: 32,
                isValidPassword: true,
                equalTo: '#password',
            },
        }, {
            'password': {
                minlength: errorMessagePasswordInvalid,
                maxlength: errorMessagePasswordInvalid,
                isValidPassword: errorMessagePasswordInvalid,
            },
            'password_confirmation': {
                minlength: errorMessageConfirmPasswordNotEqual,
                maxlength: errorMessageConfirmPasswordNotEqual,
                isValidPassword: errorMessageConfirmPasswordNotEqual,
                equalTo: errorMessageConfirmPasswordNotEqual,
            },
        });
    </script>
@endsection
