@extends('admin.layouts.admin')
@section('title', __('labels.COC001_L014'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/company" title="">{{ __('labels.COL001_L001') }}</a></li>
                    <li><span>{{ __('labels.CM001_L009') }}</span></li>
                </ul>
                <div class="row custom_wrapper">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('labels.COC001_L014') }}</h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('admin.company.verify-update') }}" id="update_company_form" method="POST">
                                @csrf
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="company" class="col-12 col-md-4">{{ __('labels.COC001_L003') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="company" class="form-control"
                                                        id="company" placeholder="{{ __('labels.COC001_L003') }}" value="{{ old('company', $company->company) }}">
                                                    @error('company')
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
                                                <label for="company_furigana" class="col-12 col-md-4">{{ __('labels.COC001_L004') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="company_furigana" class="form-control"
                                                        id="company_furigana" placeholder="{{ __('labels.COC001_L004') }}" value="{{ old('company_furigana', $company->company_furigana) }}">
                                                    @error('company_furigana')
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
                                                <label for="person_manager" class="col-12 col-md-4">{{ __('labels.COC001_L005') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="person_manager" class="form-control"
                                                        id="person_manager" placeholder="{{ __('labels.COC001_L005') }}" value="{{ old('person_manager', $company->person_manager) }}">
                                                    @error('person_manager')
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
                                                <label for="person_manager_furigana" class="col-12 col-md-4">{{ __('labels.COC001_L006') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="person_manager_furigana" class="form-control"
                                                        id="person_manager_furigana" placeholder="{{ __('labels.COC001_L006') }}"
                                                        value="{{ old('person_manager_furigana', $company->person_manager_furigana) }}">
                                                    @error('person_manager_furigana')
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
                                                <label for="email" class="col-12 col-md-4">{{ __('labels.COC001_L007') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="email" class="form-control"
                                                        id="email" placeholder="{{ __('labels.COC001_L007') }}"
                                                        value="{{ old('email', $company->email) }}">
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
                                                <label for="password" class="col-12 col-md-4">{{ __('labels.CM001_L019') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" placeholder="{{ __('labels.CM001_L019') }}"
                                                        value="{{ old('password') }}">
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
                                                <label for="password_confirmation" class="col-12 col-md-4">{{ __('labels.CM001_L020') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        id="password_confirmation" placeholder="{{ __('labels.CM001_L020') }}"
                                                        value="{{ old('password_confirmation') }}">
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
                                                <label for="commission" class="col-12 col-md-4">{{ __('labels.COC001_L008') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <div class="input-group commission-group">
                                                        <input name="commission"
                                                            type='number'
                                                            class="form-control"
                                                            id="commission"
                                                            placeholder="{{ __('labels.COC001_L008') }}"
                                                            value="{{ old('commission', $company->commission) }}">
                                                        <div class="input-group-append input-custom">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('commission')
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
                                                <label for="status" class="col-12 col-md-4">{{ __('labels.NML001_L007') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <select class="form-control" name="status" style="min-width: 215px">
                                                        @foreach ($listStatus as $key => $item)
                                                            <option value="{{ $key }}" {{ old('status', $company->status) == $key ? 'selected' : '' }} >{{ $item }}</option>
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
                                        <a href="{{route('admin.company.index')}}"
                                            class="btn btn-secondary w-100">{{ __('labels.CM001_L013') }}
                                        </a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <a href="javascript: void(0);"
                                            title=""
                                            data-toggle="modal"
                                            class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large w-100"
                                            data-target="#modal-delete"
                                            data-destination="{{ route('admin.company.index')}}"
                                            data-id="{{ $company->id }}"
                                            data-content="{{__('labels.CM001_L018',['title' => $company->company])}}"
                                            data-delete-url="{{ route('admin.company.destroy', $company->id) }}">
                                            {{__('labels.COC001_L015') }}
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
    {{-- <form action="{{ route('admin.company.update', $company->id) }}" id="add_black_list_form" method="POST">
        @csrf
        @method("PUT")
        <input type="hidden" name="status" value="{{ BLACKLIST }}">
    </form> --}}
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
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "100"]) }}';
        const errorMessageMaxCharacterForEmail = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
        const errorMessageEmailValid = '{{ __('messages.CM001_L002') }}';
        const errorMessageConfirmPasswordNotEqual = '{{ __('messages.CM001_L024') }}';
        const errorMessagePasswordInvalid = '{{ __('messages.CM001_L023') }}';
        const errorMessageInvalidNumber = '{{ __('messages.CO001_MSG002') }}';
        const errorMessageComissionInvalid = '{{ __('messages.CO001_MSG001') }}';
        $("#commission").on("keyup", function (e) {
            if (!$.isNumeric(e.target.value)) {
                $(this).val("");
            }
        });

        validation('#update_company_form', {
            'company': {
                required: true,
                maxlength : 100
            },
            'company_furigana': {
                required: true,
                maxlength : 100
            },
            'person_manager': {
                required: true,
                maxlength : 100
            },
            'person_manager_furigana': {
                required: true,
                maxlength : 100
            },
            'email': {
                required: true,
                maxlength : 255,
                isValidEmail: true
            },
            'password': {
            },
            'password_confirmation': {
                equalTo: '#password',
            },
            'commission': {
                required: true,
                min: 0,
                max: 100,
                isValidComission: true,
            },
            'status' : {
                required: true,
            }
        }, {
            'company': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'company_furigana': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'person_manager': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'person_manager_furigana': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'email': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForEmail,
                isValidEmail: errorMessageEmailValid
            },
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
            'commission': {
                required: errorMessageRequired,
                min: errorMessageInvalidNumber,
                max: errorMessageInvalidNumber,
                isValidComission: errorMessageComissionInvalid
            },
            'status' : {
                required: errorMessageRequired,
            }
        });
    </script>
@endsection
