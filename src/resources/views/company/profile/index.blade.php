@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CM001_L042') }}</a></li>
            </ul>
            @if (Session::get('deleted_success') == true)
                <div class="alert alert-success alert-dismissible message-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ __('messages.CT_MSG002') }}</p>
                </div>
                @php(Session::forget('deleted_success'))
            @elseif(Session::get('deleted_failed') == true)
                <div class="alert alert-error alert-dismissible message-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ __('messages.CT_MSG003') }}</p>
                </div>
                @php(Session::forget('deleted_failed'))
            @endif
            @if ($message = Session::get('success'))
                <div class="p-2 alert alert-success pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{ $message }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L042') }}</h3>
                        </div>
                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="m-profile__content pt-md-3">
                                    <div class="m-profile__item d-flex align-items-center">
                                        <div>{{ __('labels.CM001_L043') }}</div>
                                        <div></div>
                                        <a href="{{ route('company.profile.show') }}" title=""
                                            class="btn btn-blue ml-auto">{{ __('labels.CM001_L044') }}</a>

                                    </div>
                                    <div class="m-profile__item d-flex align-items-center justify-content-between">
                                        <div>{{ __('labels.CM001_L045') }}</div>
                                        <div>*************</div>
                                        <a href="{{ route('company.profile.show.password') }}" title=""
                                            class="btn btn-blue ml-auto">{{ __('labels.CM001_L044') }}</a>
                                    </div>
                                    <div class="m-profile__item d-flex align-items-center justify-content-between">
                                        <div>{{ __('labels.CM001_L046') }}</div>
                                        <div>
                                            {{ $companyInfo->status_two_step_verification == 1 ? __('labels.CM001_L047') : __('labels.CM001_L048') }}
                                        </div>
                                        <a href="{{ route('company.profile.show.setting-two-step-verification') }}"
                                            title="" class="btn btn-blue ml-auto">{{ __('labels.CM001_L044') }}</a>
                                    </div>
                                    <div class="m-profile__item d-flex align-items-center justify-content-between">
                                        <div>{{ __('labels.CM001_L049') }}</div>
                                        <div>
                                            {{ $companyInfo->status_notifice == 1 ? __('labels.CM001_L051') : __('labels.CM001_L052') }}
                                        </div>
                                        <a href="{{ route('company.profile.show.setting-notify') }}" title=""
                                            class="btn btn-blue ml-auto">{{ __('labels.CM001_L044') }}</a>
                                    </div>
                                    <div class="m-profile__item d-flex align-items-center justify-content-between">
                                        <div>{{ __('labels.CM001_L050') }}</div>
                                        <div>*********0987</div>
                                        <a href="{{ route('company.profile.show.credit-card') }}" title=""
                                            class="btn btn-blue ml-auto">{{ __('labels.CM001_L044') }}</a>
                                    </div>
                                </div>
                                <div class="mt-5 position-relative m-profile__withdraw">
                                    <h2 class="mypage__sub-title title-block-line">{{ __('labels.CM001_L053') }}</h2>
                                    <a href="javascript: void(0);" title="" data-toggle="modal"
                                        class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                        data-target="#modal-delete" data-id="{{ $companyInfo->id }}"
                                        data-content="{{ __('labels.CM001_L018', ['title' => $companyInfo->company]) }}"
                                        data-delete-url="{{ route('company.profile.delete', $companyInfo->id) }}">
                                        {{ __('labels.CM001_L005') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- body end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.modal.delete')
@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
@endsection
