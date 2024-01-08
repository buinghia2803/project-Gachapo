@extends('admin.layouts.admin')
@section('title', __('labels.AUM001_L005'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/user" title="">{{ __('labels.AUM001_L001') }}</a></li>
                <li><span>{{ __('labels.CM001_L009') }}</span></li>
            </ul>
            <div class="row custom_wrapper">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.AUM001_L005') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('admin.user.verify-update') }}" id="update_user_form" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="name" class="col-12 col-md-4">{{__('labels.ADM001_L002')}}<span
                                                class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="name" class="form-control"
                                                    id="name" placeholder="{{__('labels.ADM001_L002')}}" value="{{ old('name', $user->name) }}">
                                                @error('name')
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
                                            <label for="name_furigana" class="col-12 col-md-4">{{__('labels.ADM001_L010')}}<span
                                                class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="name_furigana" class="form-control"
                                                    id="name_furigana" placeholder="{{__('labels.ADM001_L010')}}" value="{{ old('name_furigana', $user->name_furigana) }}">
                                                @error('name_furigana')
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
                                            <label for="email" class="col-12 col-md-4">{{__('labels.CM001_L030')}}<span
                                                class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="email" class="form-control"
                                                    id="email" placeholder="{{__('labels.CM001_L030')}}" value="{{ old('email', $user->email) }}">
                                                @error('email')
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
                                            <label for="password" class="col-12 col-md-4">{{__('labels.CM001_L019')}}<span
                                                class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="password" name="password" class="form-control"
                                                    id="password" placeholder="{{__('labels.CM001_L019')}}" value="{{ old('password') }}">
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
                                            <label for="password_confirmation" class="col-12 col-md-4">{{__('labels.CM001_L020')}}<span
                                                class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    id="password_confirmation" placeholder="{{__('labels.CM001_L020')}}" value="{{ old('password_confirmation') }}">
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
                                            <label for="status" class="col-12 col-md-4">{{ __('labels.NML001_L007') }}</label>
                                            <div class="col-12 col-md-8">
                                                <select class="form-control" name="status" style="min-width: 215px">
                                                    @foreach ($listStatus as $key => $item)
                                                        <option value="{{ $key }}" {{ old('status', $user->status) == $key ? 'selected' : '' }} >{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
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
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-sm-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            {{ __('labels.CM001_L014') }}
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <a href="{{route('admin.user.index')}}"
                                            class="btn btn-secondary w-100">{{ __('labels.CM001_L013') }}
                                        </a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <a href="javascript: void(0);"
                                            title=""
                                            data-toggle="modal"
                                            class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large w-100"
                                            data-target="#modal-delete"
                                            data-destination="{{ route('admin.user.index')}}"
                                            data-id="{{ $user->id }}"
                                            data-content="{{__('labels.CM001_L018',['title' => $user->name])}}"
                                            data-delete-url="{{ route('admin.user.destroy', $user->id) }}"
                                            style="min-width: max-content;">
                                            {{__('labels.ADM001_L011') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{__('labels.CM001_L014')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text-delete"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.CM001_L013')}}</button>
                    <button type="button" class="btn btn-danger delete">{{__('labels.CM001_L005')}}</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        div.error-validate {
            font-size: 14px;
            color: red;
        }
        div.error-valid {
            font-size: 14px;
            color: red;
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
        const errorMessageMaxCharacterForName = '{{ __('messages.CM001_L011', ["attr" => "100"]) }}';
        const errorMessageEmailValid = '{{ __('messages.CM001_L002') }}';
        const errorMessageConfirmPasswordNotEqual = '{{ __('messages.CM001_L012') }}';
        const errorMessagePasswordMaxCharacter = '{{ __('messages.CM001_L029', ['min' => '8', 'max' => '32']) }}';
        const errorMessagePasswordMinCharacter = '{{ __('messages.CM001_L029', ['min' => '8', 'max' => '32']) }}';
        const errorMessagePasswordInvalid = '{{ __('messages.CM001_L016') }}';
        const errorMessageMaxNumber = '{{ __('messages.CM001_L013', ["num" => "100"]) }}';
        const errorMessageMinNumber = '{{ __('messages.CM001_L014', ["num" => "0"]) }}';
        const errorMessageComissionInvalid = '{{ __('messages.CO001_MSG001') }}';

        validation('#update_user_form', {
            'name': {
                required: true,
                maxlength : 100
            },
            'name_furigana': {
                required: true,
                maxlength : 100
            },
            'email': {
                required: true,
                maxlength : 255,
                isValidEmail: true
            },
            'password': {
                minlength : 8,
                maxlength : 32,
                isValidPasswordForCompany: true
            },
            'password_confirmation': {
                minlength : 8,
                maxlength : 32,
                isValidPasswordForCompany: true,
                equalTo: '#password'
            },
            'status' : {
                required: true
            }
        }, {
            'name': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForName
            },
            'name_furigana': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForName
            },
            'email': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter,
                isValidEmail: errorMessageEmailValid
            },
            'password': {
                minlength: errorMessagePasswordMinCharacter,
                maxlength: errorMessagePasswordMaxCharacter,
                isValidPasswordForCompany: errorMessagePasswordInvalid,
            },
            'password_confirmation': {
                minlength: errorMessagePasswordMinCharacter,
                maxlength: errorMessagePasswordMaxCharacter,
                isValidPasswordForCompany: errorMessagePasswordInvalid,
                equalTo: errorMessageConfirmPasswordNotEqual,
            },
            'status' : {
                required: errorMessageRequired,
            }
        });
    </script>
@endsection
