@extends('admin.layouts.admin')
@section('title', __('labels.BNN001_L011').' - '.__('labels.CM001_L016'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.banners.index') }}" title="">{{__('labels.BNN001_L001')}}</a></li>
            <li><a href="{{ route('admin.banners.edit', $data->id) }}" title="">{{__('labels.CM001_L009')}}</a></li>
            <li><span>{{__('labels.CM001_L016')}}</span></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.BNN001_L011').' - '.__('labels.CM001_L016')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banners.update', $data->id) }}" id="create_banner_main_visuals_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BNN001_L005' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $title ?? '' }}</p>
                                    <input type="hidden" name="title" value="{{ $title ?? '' }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BNN001_L006' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $link ?? '' }}</p>
                                    <input type="hidden" name="link" value="{{ $link ?? '' }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.BNN001_L008' )}}</label>
                                <div class="col-12 col-md-8">
                                    @if (!empty($attachment_base64))
                                        <img src="{{ $attachment_base64 ?? '' }}" height="150" alt="">
                                        <input type="hidden" name="attachment" value="{{ $attachment_base64 ?? '' }}">
                                    @else
                                        <img src="{{ $attachment_input ?? '' }}" height="150" alt="">
                                    @endif
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
            localStorage.removeItem("valImageUpdate");
        });
    </script>
@endsection