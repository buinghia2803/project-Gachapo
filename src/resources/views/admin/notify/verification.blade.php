
@extends('admin.layouts.admin')
@section('title', __('labels.CM001_L015'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/notify" title="">{{ __('labels.NML001_L001') }}</a></li>
                <li><a href="/admin/notify/create" title="">{{ __('labels.NML001_L003') }}</a></li>
                <li><span>{{ __('labels.CM001_L016') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('labels.CM001_L015') }}</h3>
                    </div>
                    <!-- form start -->
                    <form action="{{ route('admin.notify.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="col-12 mt-4">
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.CM001_L033') }}</label>
                                <div class="col-lg-10 col-md-8">
                                    <p class="confirm_info custom-text">{{ $data['title'] }}</p>
                                    <input type="hidden" name="title" value="{{ $data['title'] }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <span class="noti-label">{{ __('labels.NML001_L006') }}</span>
                                </div>
                                <div class="col-lg-10 col-md-8">
                                    <div class="confirm_info custom-text">{!! $data['content'] !!}</div>
                                    <textarea hidden name="content" rows="10" id="content">{{ $data['content'] }}</textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NML001_L002') }}</label>
                                <div class="col-lg-10 col-md-8">
                                    <p class="confirm_info">{{ $data['start_time'] }}</p>
                                    <input class="form-control"
                                        hidden
                                        type="text"
                                        name="start_time"
                                        autocomplete="off"
                                        id="start_time"
                                        placeholder="公開開始日時"
                                        value="{{ $data['start_time'] }}" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NMC001_L002') }}</label>
                                <div class="col-lg-10 col-md-8">
                                    <p class="confirm_info">{{ $data['end_time'] }}</p>
                                    <input class="form-control"
                                        hidden
                                        name="end_time"
                                        autocomplete="off"
                                        id="end_time"
                                        placeholder="公開終了日時"
                                        value="{{ $data['end_time'] }}" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NMC001_L005') }}</label>
                                <div class="col-lg-10 col-md-8">
                                    <p class="confirm_info">{{ $listStatus[$data['status']] }}</p>
                                    <input type="hidden" name="status" value="{{ $data['status'] }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NMC001_L006') }}</label>
                                <div class="col-lg-10 col-md-8">
                                    <p class="confirm_info">{{ $listType[$data['type']] }}</p>
                                    <input type="hidden" name="type" value="{{ $data['type'] }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4"></label>
                                <div class="col-lg-10 col-md-8 d-flex justify-content-center d-md-inline-block">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('labels.CM001_L014') }}</button>
                                    <button type="button"
                                        class="btn btn-primary"
                                        id="save_notify">{{ __('labels.CM001_L017') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        .error-image {
            font-size: 14px;
            color: red;
        }
    </style>
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
        $("#save_notify").on('click', function() {
            sessionStorage.setItem("start_time", $("#start_time").val());
            sessionStorage.setItem("end_time", $("#end_time").val());
            history.back();
        });
    });
</script>
@endsection
