@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CM001_L042') }}</a></li>
                <li><span>{{ __('labels.CM001_L046') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L046') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{route('company.profile.post.setting-two-step-verification')}}" id="create_company_form" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="password" class="col-12 col-md-4">{{ __('labels.CM001_L046') }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <div id="status_two_step_verification" role="radiogroup" tabindex="-1"
                                                     class="bv-no-focus-ring">
                                                    <div class="custom-control custom-control-inline custom-radio">
                                                        <input id="status_two_step_verification_BV_option_0"
                                                               type="radio" name="status_two_step_verification"
                                                               value="1" checked="{{$user->status_two_step_verification == 1 ? 'checked' : ''}}"  class="custom-control-input"><label
                                                            for="status_two_step_verification_BV_option_0"
                                                            class="custom-control-label"><span>{{ __('labels.CM001_L047') }}</span></label>
                                                    </div><br/>
                                                    <div class="custom-control custom-control-inline custom-radio">
                                                        <input id="status_two_step_verification_BV_option_1"
                                                               type="radio" name="status_two_step_verification"
                                                               value="0" checked="{{$user->status_two_step_verification == 0 ? 'checked' : ''}}" class="custom-control-input"><label
                                                            for="status_two_step_verification_BV_option_1"
                                                            class="custom-control-label"><span>{{ __('labels.CM001_L048') }}</span></label>
                                                    </div>
                                                </div>
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
                                            <label class="col-12 col-md-4"></label>
                                            <div
                                                class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                <button type="submit"
                                                        class="btn btn-primary">{{ __('labels.CM001_L061') }}
                                                </button>
                                                <a href="{{route('company.profile')}}" class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L017') }}</a>
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
@endsection
