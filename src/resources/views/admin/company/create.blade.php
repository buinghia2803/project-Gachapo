@extends('admin.layouts.admin')
@section('title', __('labels.COC001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/company" title="">{{ __('labels.COL001_L001') }}</a></li>
                    <li><span>{{ __('labels.COC001_L002') }}</span></li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('labels.COC001_L001') }}</h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('admin.company.verify') }}" id="create_company_form" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="company" class="col-12 col-md-4">{{ __('labels.COC001_L003') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="company" class="form-control"
                                                        id="company" placeholder="{{ __('labels.COC001_L003') }}" value="{{ old('company') }}">
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
                                                        id="company_furigana" placeholder="{{ __('labels.COC001_L004') }}" value="{{ old('company_furigana') }}">
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
                                                        id="person_manager" placeholder="{{ __('labels.COC001_L005') }}" value="{{ old('person_manager') }}">
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
                                                        value="{{ old('person_manager_furigana') }}">
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
                                                        value="{{ old('email') }}">
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
                                                <label for="password" class="col-12 col-md-4">{{ __('labels.CM001_L019') }}<span
                                                        class="required">*</span></label>
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
                                                <label for="password_confirmation" class="col-12 col-md-4">{{ __('labels.CM001_L020') }}<span
                                                        class="required">*</span></label>
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
                                                    <div class="input-group mb-3 commission-group">
                                                        <input name="commission"
                                                            type='number'
                                                            class="form-control"
                                                            id="commission"
                                                            placeholder="{{ __('labels.COC001_L008') }}"
                                                            value="{{ old('commission') }}">
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
                                                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }} >{{ $item }}</option>
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
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4"></label>
                                                <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                    <button type="submit"
                                                            class="btn btn-primary">{{ __('labels.CM001_L014') }}</button>
                                                    <a href="{{route('admin.company.index')}}"
                                                        class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L013') }}
                                                    </a>
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
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
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
    </script>
    <script src="{{ url(mix('js/admin/company/create_company_validation.js')) }}"></script>
@endsection
