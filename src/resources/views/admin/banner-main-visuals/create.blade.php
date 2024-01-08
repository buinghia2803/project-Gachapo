@extends('admin.layouts.admin')
@section('title', __('labels.BMV001_L011').' - '.__('labels.CM001_L006'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.banner-main-visuals.index') }}" title="">{{__('labels.BMV001_L001')}}</a></li>
            <li><span>{{__('labels.CM001_L006')}}</span></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.BMV001_L011').' - '.__('labels.CM001_L006')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banner-main-visuals.create-confirm') }}" id="create_banner_main_visuals_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.components.form.text', [
                                'name' => 'title',
                                'value' => '',
                                'labels' => __('labels.BMV001_L003'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])
                            @include('admin.components.form.text', [
                                'name' => 'link',
                                'value' => '',
                                'labels' => __('labels.BMV001_L005'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])
                            @include('admin.components.form.image', [
                                'name' => 'attachment',
                                'value' => '',
                                'labels' => __('labels.BMV001_L007'),
                                'note' => __('labels.BMV001_L008').'<br>'.__('labels.BMV001_L009'),
                                'button_text' => __('labels.BMV001_L010'),
                                'required' => true,
                            ])
                            <div class="row">
                                <div class="form-group col-12 col-xl-9">
                                    <div class="row d-flex align-items-baseline">
                                        <label class="col-12 col-md-4"></label>
                                        <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                            <button type="submit" id="btn-storage" class="btn btn-primary">{{__('labels.CM001_L014')}}</button>
                                            <a href="{{route('admin.banner-main-visuals.index')}}" class="btn btn-secondary ml-0 ml-3">{{__('labels.CM001_L013')}}</a>
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
</div>
@endsection

@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageNameMaxLength = '{{ __('messages.CM001_L011', ['attr' => 30]) }}';
        const errorMessageRequiredImage = '{{ __('messages.CM001_L001') }}';
        const errorMessageFormatImage = '{{ __('messages.BMV001_L001') }}';
        const errorMessageFilesizeImage = '{{ __('messages.CM001_L004', [ 'attr' => '20MB' ]) }}';
        validation('#create_banner_main_visuals_form', {
            'title': {
                required: true,
                maxlength: 30,
            },
            'link': {
                required: true,
            },
            'attachment': {
                requiredFile: true,
            }
        }, {
            'title': {
                required: errorMessageRequired,
                maxlength: errorMessageNameMaxLength,
            },
            'link': {
                required: errorMessageRequired,
            },
            'attachment': {
                requiredFile: errorMessageRequiredImage,
            }
        });
        imagePreview('#attachment', {
            'required': errorMessageRequiredImage,
            'filesize': errorMessageFilesizeImage,
            'extension': errorMessageFormatImage,
        });
    </script>

    <script type="text/javascript">
        if (localStorage.getItem('valImages')) {
            $('input[name=attachment_base64]').val(localStorage.getItem('valImages'));
            $('#image-preview-src').attr("src", localStorage.getItem('valImages'));
        }
        localStorage.removeItem("valImages");
        $("#btn-storage").on('click', function() {
            localStorage.setItem('valImages', $('input[name=attachment_base64]').val());
        });
    </script>
@endsection
