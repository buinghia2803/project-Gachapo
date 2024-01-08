@extends('admin.layouts.admin')
@section('title', __('labels.ADM001_L008').' - '.__('labels.CM001_L006'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.admin_users.index') }}" title="">{{__('labels.ADM001_L001')}}</a></li>
            <li><span>{{__('labels.CM001_L006')}}</span></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.ADM001_L008').' - '.__('labels.CM001_L006')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.admin_users.store') }}" id="create_admin_users_form" method="POST" enctype="multipart/form-data">
                            @csrf

                            @include('admin.components.form.text', [
                                'name' => 'name',
                                'value' => '',
                                'labels' => __('labels.ADM001_L009'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])
                            
                            @include('admin.components.form.text', [
                                'name' => 'name_furigana',
                                'value' => '',
                                'labels' => __('labels.ADM001_L010'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

                            @include('admin.components.form.text', [
                                'name' => 'email',
                                'value' => '',
                                'labels' => __('labels.ADM001_L007'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

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
                                'labels' => __('labels.CM001_L020'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

                            @include('admin.components.form.select', [
                                'name' => 'status',
                                'value' => '',
                                'labels' => __('labels.ADM001_L003'),
                                'required' => true,
                                'options' => $status,
                            ])
                            
                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8">
                                    <button type="submit" class="btn btn-primary">{{__('labels.CM001_L010')}}</button>
                                    <a href="{{route('admin.admin_users.index')}}" class="btn btn-secondary ml-0 ml-3">{{__('labels.CM001_L013')}}</a>
                                </div>
                            </div>
                        </form>

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
        const errorMessageMaxLength100 = '{{ __('messages.CM001_L011', ['attr' => 100]) }}';
        const errorMessageMaxLength255 = '{{ __('messages.CM001_L011', ['attr' => 255]) }}';
        const errorMessageEmailWrongFomat = '{{ __('messages.CM001_L018') }}';
        const errorMessagePasswordWrongFomat = '{{ __('messages.CM001_L023') }}';
        const errorMessagePasswordConfirmNotEqual = '{{ __('messages.CM001_L024') }}';
        validation('#create_admin_users_form', {
            'name': {
                required: true,
                maxlength: 100,
            },
            'name_furigana': {
                required: true,
                maxlength: 100,
            },
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
            'password_confirmation': {
                required: true,
                minlength : 8,
                maxlength : 32,
                equalTo: '#password',
            },
            'status': {
                required: true,
            },
        }, {
            'name': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength100,
            },
            'name_furigana': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength100,
            },
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
            'password_confirmation': {
                required: errorMessageRequired,
                minlength: errorMessagePasswordConfirmNotEqual,
                maxlength: errorMessagePasswordConfirmNotEqual,
                isValidPassword: errorMessagePasswordConfirmNotEqual,
                equalTo: errorMessagePasswordConfirmNotEqual,
            },
            'status': {
                required: errorMessageRequired,
            },
        });
    </script>
@endsection