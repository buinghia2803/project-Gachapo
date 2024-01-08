@extends('admin.layouts.admin')
@section('title', __('labels.AMT001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/mail-templates" title="">{{ __('labels.AMT001_L001') }}</a></li>
            </ul>
            <div class="row">
                <div class="col-12">
                    {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.AMT001_L001') }}</h3>
                        </div>
                        <div class='card-body mail-template'>
                            @include('admin.mail-templates.templates')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input hidden id="templates-type-info" value="{{ json_encode($templatesTypeInfo) }}">
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
    <script src="{{ url(mix('js/ckeditor/ckeditor.js')) }}"></script>
    <script type="text/javascript">
        const list_mailtemplate = {!! json_encode($templatesTypeInfo) !!};
        const errorInputRequired = '{{__('messages.CM001_L001')}}';
        const errorMaxlength255 = '{{__('messages.CM001_L011', ["attr" => "255"])}}';
        const errorMessageEmailValid = '{{ __('messages.CM001_L018') }}';
        const defaultTextAttachment = '{{__('messages.MT001_MSG001')}}';
        const attachmentFileMaxSize = '{{__('messages.MT_MSG001')}}';
    </script>
    <script>
        $(document).ready(function() {
            $('.cc').select2({
                tags: true,
                language: {
                    noResults: function(){
                    return "データーがありません。";
                }
                },
            });
            $('.bcc').select2({
                tags: true,
                language: {
                    noResults: function(){
                    return "データーがありません。";
                }
                },
            });
        });
        CKEDITOR.config.filebrowserUploadUrl = '{!! route('admin.upload-img', ['_token' => csrf_token()]) !!}';
    </script>
    <script type="text/javascript" src="{{ url(mix('js/admin/mail-templates/filesize.min.js')) }}"></script>
    <script type="text/javascript" src="{{ url(mix('js/admin/mail-templates/index.js')) }}"></script>
@endsection
