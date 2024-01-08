@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CM001_L042') }}</a></li>
                <li><span>{{ __('labels.CM001_L062') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L062') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('company.profile.update') }}" id="create_company_form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method("POST")
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="company" class="col-12 col-md-4">{{ __('labels.COC001_L003') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="company" class="form-control" id="company"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('company', $companyInfo->company) }} ">
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
                                            <label for="company_furigana" class="col-12 col-md-4">{{ __('labels.COC001_L004') }}）<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="company_furigana" class="form-control"
                                                    id="company_furigana" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('company_furigana', $companyInfo->company_furigana) }}">
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
                                                    id="person_manager" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('person_manager', $companyInfo->person_manager) }}">
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
                                                    id="person_manager_furigana" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('person_manager_furigana', $companyInfo->person_manager_furigana) }}">
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
                                            <label for="phone" class="col-12 col-md-4">{{ __('labels.CM001_L025') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('phone', $companyInfo->phone) }}">
                                                @error('phone')
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
                                            <label for="email" class="col-12 col-md-4">Eメール<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="email" class="form-control" id="email"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('email', $companyInfo->email) }}">
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
                                            <label for="company_information" class="col-12 col-md-4">{{ __('labels.COC001_L019') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <textarea style="height: auto" name="company_information" class="form-control" rows="4" id="company_information"
                                                    placeholder="{{ __('labels.CM001_L008') }}">{{ $companyInfo->company_information }}</textarea>
                                                @error('company_information')
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
                                            <label for="site_url" class="col-12 col-md-4">{{ __('labels.COC001_L018') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input name="site_url" type='text' class="form-control" id="site_url"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('site_url', $companyInfo->site_url) }}">
                                                @error('site_url')
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
                                            <label for="company_address" class="col-12 col-md-4">{{ __('labels.COC001_L017') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input name="company_address" type='text' class="form-control"
                                                    id="company_address" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('company_address', $companyInfo->company_address) }}">
                                                @error('company_adress')
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
                                            <label for="registered_copy_attachment"
                                                class="col-12 col-md-4">{{ __('labels.COC001_L020') }}{{ __('labels.COC001_L021') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <div class="box-input-file position-relative">
                                                    <label for="files" class="btn">{{ __('labels.BMV001_L010') }}</label>
                                                    <div>
                                                        <p style="font-size: 15px">
                                                            {{ $companyInfo->registered_copy_attachment != '' ? $filename[count($filename) - 1] : __('labels.CM001_L064') }}
                                                        </p>
                                                    </div>
                                                    <input id="files" style="visibility:hidden;" type="file"
                                                        name="registered_copy_attachment" id="registered_copy_attachment">
                                                </div>
                                                <img src="{{ $companyInfo->registered_copy_attachment }}" width="100"
                                                    alt="">
                                                @error('registered_copy_attachment')
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
                                                <button type="submit" class="btn btn-primary">{{ __('labels.CM001_L044') }}</button>
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
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L002', ['attr' => '100']) }}';
        const errorMessageMaxCharacterTextArea = '{{ __('messages.CM001_L002', ['attr' => '1000']) }}';
        const errorMessageMaxCharacterForEmail = '{{ __('messages.CM001_L002', ['attr' => '255']) }}';
        const errorMessageEmailValid = '{{ __('messages.CM001_L002') }}';
        const errorMessageInvalidNumber = '{{ __('messages.CO001_MSG002') }}';
        const errorMessageComissionInvalid = '{{ __('messages.CO001_MSG001') }}';

        validation('#create_company_form', {
            'company': {
                required: true,
                maxlength: 100
            },
            'company_furigana': {
                required: true,
                maxlength: 100
            },
            'person_manager': {
                required: true,
                maxlength: 100
            },
            'person_manager_furigana': {
                required: true,
                maxlength: 100
            },
            'company_information': {
                required: true,
                maxlength: 1000
            },
            'email': {
                required: true,
                maxlength: 255,
                isValidEmail: true
            },
            'site_url': {
                required: true,
                maxlength: 255,
            },
            'company_address': {
                required: true,
                maxlength: 255,
            },
            'registered_copy_attachment': {
                required: true,
            },
            'phone': {
                required: true,
                minlength: 8,
                maxlength: 32,
                isValidNumber: true,
            },
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
            'company_information': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterTextArea
            },
            'email': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForEmail,
                isValidEmail: errorMessageEmailValid
            },
            'site_url': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForEmail,
            },
            'company_address': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterForEmail,
            },
            'registered_copy_attachment': {
                required: errorMessageRequired,
            },
            'phone': {
                required: errorMessageRequired,
                minlength: errorMessageInvalidNumber,
                maxlength: errorMessageInvalidNumber,
                isValidComission: errorMessageComissionInvalid
            },
        });

        // custom input type=file
        $("#files").change(function() {
            filename = this.files[0].name;
            console.log(filename);
        });
    </script>
@endsection
