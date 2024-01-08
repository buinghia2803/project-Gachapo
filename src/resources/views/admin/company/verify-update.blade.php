@extends('admin.layouts.admin')
@section('title', __('labels.COC001_L009'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/company" title="">{{ __('labels.COL001_L001') }}</a></li>
                    <li><a href="/admin/company/{{ $data['company_id'] }}/edit" title="">{{ __('labels.CM001_L009') }}</a></li>
                    <li><span>{{ __('labels.CM001_L016') }}</span></li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('labels.COC001_L009') }}</h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('admin.company.update', $data['company_id']) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L003') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['company'] }}</p>
                                                    <input type="hidden" name="company"
                                                        value="{{ $data['company'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L004') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['company_furigana'] }}</p>
                                                    <input type="hidden" name="company_furigana"
                                                        value="{{ $data['company_furigana'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L005') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['person_manager'] }}</p>
                                                    <input type="hidden" name="person_manager"
                                                        value="{{ $data['person_manager'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L006') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['person_manager_furigana'] }}</p>
                                                    <input type="hidden" name="person_manager_furigana"
                                                        value="{{ $data['person_manager_furigana'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L007') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['email'] }}</p>
                                                    <input type="hidden" name="email"
                                                        value="{{ $data['email'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    @if (isset($data['password']) && !empty($data['password']))
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.CM001_L019') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['password'] }}</p>
                                                    <input type="hidden" name="password"
                                                        value="{{ $data['password'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.COC001_L008') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $data['commission'] }}<span>%</span></p>
                                                    <input type="hidden" name="commission"
                                                        value="{{ $data['commission'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.NML001_L007') }}</label>
                                                <div class="col-12 col-md-8">
                                                    <p class="confirm_info">{{ $listStatus[$data['status']] }}</p>
                                                    <input type="hidden" name="status" value="{{ $data['status'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <div class="col-12 d-flex justify-content-center d-md-inline-block">
                                                    <button type="submit"
                                                            class="btn btn-primary">{{ __('labels.CM001_L002') }}</button>
                                                    <button type="button" id="back_to_previous"
                                                        class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L017') }}</button>
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
    <script>
        $("#back_to_previous").on("click", function (){
            history.back();
        });
    </script>
@endsection
