@extends('admin.layouts.admin')
@section('title', __('labels.BMV001_L011').' - '.__('labels.CM001_L016'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.banner-main-visuals.index') }}" title="">{{__('labels.BMV001_L001')}}</a></li>
            <li><a href="{{ route('admin.banner-main-visuals.create') }}" title="">{{__('labels.CM001_L006')}}</a></li>
            <li><span>{{__('labels.CM001_L016')}}</span></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.BMV001_L011').' - '.__('labels.CM001_L016')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banner-main-visuals.store') }}" id="create_banner_main_visuals_form" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BMV001_L003' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $title ?? '' }}</p>
                                    <input type="hidden" name="title" value="{{ $title ?? '' }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BMV001_L005' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $link ?? '' }}</p>
                                    <input type="hidden" name="link" value="{{ $link ?? '' }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BMV001_L007' )}}</label>
                                <div class="col-12 col-md-8">
                                    <img src="{{ $attachment_base64 ?? '' }}" height="150" alt="">
                                    <input type="hidden" name="attachment" value="{{ $attachment_base64 ?? '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8">
                                    <button type="submit" id="btn-save-banner" class="btn btn-primary">{{__('labels.CM001_L010')}}</button>
                                    <a onclick="back()" class="btn btn-secondary ml-0 ml-3">{{__('labels.CM001_L017')}}</a>
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
    <script>
        function back() {
            history.back();
        }

        $('#btn-save-banner').on('click', function (){
            localStorage.removeItem("valImages");
        });
    </script>
@endsection
