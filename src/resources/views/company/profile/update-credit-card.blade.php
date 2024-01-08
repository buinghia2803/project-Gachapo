@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CDB001_L005') }}</a></li>
                <li><span>{{ __('labels.CDB001_L005') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L050') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('company.profile.update.credit-card') }}" id="create_company_form"
                            method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="bank_name" class="col-12 col-md-4">{{ __('labels.CM001_L054') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="bank_name" class="form-control" id="company"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('bank_name', $user->bank_name) }}">
                                                @error('bank_name')
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
                                            <label for="branch_name" class="col-12 col-md-4">{{ __('labels.CM001_L055') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="branch_name" class="form-control"
                                                    id="branch_name" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('branch_name', $user->branch_name) }}">
                                                @error('branch_name')
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
                                            <label for="bank_code" class="col-12 col-md-4">{{ __('labels.CM001_L056') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="bank_code" class="form-control" id="bank_code"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('bank_code', $user->bank_code) }}">
                                                @error('bank_code')
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
                                            <label for="branch_code" class="col-12 col-md-4">{{ __('labels.CM001_L057') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="branch_code" class="form-control"
                                                    id="branch_code" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('branch_code', $user->branch_code) }}">
                                                @error('branch_code')
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
                                            <label for="bank_type" class="col-12 col-md-4">{{ __('labels.CM001_L058') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="bank_type" class="form-control" id="bank_type"
                                                    placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('bank_type', $user->bank_type) }}">
                                                @error('bank_type')
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
                                            <label for="bank_number" class="col-12 col-md-4">{{ __('labels.CM001_L059') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="bank_number" class="form-control"
                                                    id="bank_number" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('bank_number', $user->bank_number) }}">
                                                @error('bank_number')
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
                                            <label for="bank_holder" class="col-12 col-md-4">{{ __('labels.CM001_L060') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input name="bank_holder" type='text' class="form-control"
                                                    id="bank_holder" placeholder="{{ __('labels.CM001_L008') }}"
                                                    value="{{ old('bank_holder', $user->bank_holder) }}">
                                                @error('bank_holder')
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
                                                <button type="submit" class="btn btn-primary">{{ __('labels.CM001_L061') }}</button>
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
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ['attr' => '100']) }}';
        const errorMessageMaxCharacterNumber = '{{ __('messages.CM001_L036', ['attr' => '50']) }}';
        const errorMessageMaxCharacterHolder = '{{ __('messages.CM001_L037', ['attr' => '255']) }}';

        validation('#create_company_form', {
            'bank_name': {
                required: true,
                maxlength: 100
            },
            'branch_name': {
                required: true,
                maxlength: 100
            },
            'bank_code': {
                required: true,
                maxlength: 100
            },
            'branch_code': {
                required: true,
                maxlength: 100
            },
            'bank_type': {
                required: true,
                maxlength: 50,
            },
            'bank_number': {
                required: true,
                maxlength: 50,
            },
            'bank_holder': {
                required: true,
                maxlength: 100,
            },
        }, {
            'bank_name': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'branch_name': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'bank_code': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'branch_code': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'bank_type': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterNumber,
            },
            'bank_number': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterNumber,
            },
            'bank_holder': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacterHolder,
            },
        });
    </script>
@endsection
