@extends('admin.layouts.admin')
@section('title', __('labels.NMC001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/notify" title="">{{ __('labels.NML001_L001') }}</a></li>
                <li><span>{{ __('labels.CM001_L006') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('labels.NMC001_L001') }}</h3>
                    </div>
                    <!-- form start -->
                    <form action="{{ route('admin.notify.verify') }}" enctype="multipart/form-data" id="create_notify_form" method="POST">
                        @csrf
                        <div class="col-12 mt-4">
                            <div class="row form-group">
                                <label for="title" class="col-md-2">{{ __('labels.CM001_L033') }}<span
                                    class="required">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control"
                                        type="text"
                                        name="title"
                                        id="title"
                                        placeholder="{{ __('labels.CM001_L033') }}"
                                        value="{{ old('title') }}" />
                                    @error('title')
                                    <div class="error-valid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="content" class="col-md-2 mt-3">{{ __('labels.ATM001_L003') }}<span
                                    class="required">*</span></label>
                                <div class="col-md-8">
                                    <textarea id="content" name="content" class="form-control textarea-editor" data-input='editor' cols="15">
                                        {!! old('content') !!}
                                    </textarea>
                                    <div class="textarea-error"></div>
                                    @error('content')
                                    <div class="error-valid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="start_time" class="col-md-2">{{ __('labels.NML001_L002') }}<span
                                    class="required">*</span></label>
                                <div class="col-md-8">
                                    <div id='start-time-error' class="error-valid mb-2"></div>
                                    <input class="form-control"
                                        type="text"
                                        name="start_time"
                                        autocomplete="off"
                                        id="start_time"
                                        placeholder="{{ __('labels.NML001_L002') }}"
                                        value="{{ old('start_time') }}" />
                                    @error('start_time')
                                    <div class="error-valid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                    <label for="end_time" class="col-md-2">{{ __('labels.NMC001_L002') }}</label>
                                    <div class="col-md-8">
                                        <div id='end-time-error' class="error-valid mb-2"></div>
                                        <input class="form-control datepicker"
                                            name="end_time"
                                            autocomplete="off"
                                            id="end_time"
                                            placeholder="{{ __('labels.NMC001_L002') }}"
                                            value="{{ old('end_time') }}" />
                                        @error('end_time')
                                        <div class="error-valid">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NMC001_L005') }}<span
                                        class="required">*</span></label>
                                <div class="col-lg-10 col-md-8">
                                    <div class="switch-container">
                                        <input type="checkbox" name="status" checked {{ old('status') ? "checked" : "" }} id="noti_type"/>
                                        <label for="noti_type"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4">{{ __('labels.NMC001_L006') }}<span
                                        class="required">*</span></label>
                                <div class="col-lg-10 col-md-8">
                                    @foreach ($listType as $key => $item)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-control"
                                                value="{{ $key }}"
                                                type="radio"
                                                name="type"
                                                id="type-{{ $key }}"
                                                {{ $key === old('type') ? 'checked':'' }}>
                                            <label class="form-check-label" for="type-{{ $key }}">
                                                {{ $item }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <div id="type-err"></div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-lg-2 col-md-4"></label>
                                <div class="col-lg-10 col-md-8 d-flex justify-content-center d-md-inline-block">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            id="create_notify">{{ __('labels.CM001_L014') }}</button>
                                    <a href="{{route('admin.notify.index')}}"
                                        class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L013') }}
                                    </a>
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
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script>
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
        const errorStartTime = '{{ __('messages.ANM001_MSG001') }}';
        const errorEndTime = '{{ __('messages.ANM001_MSG002') }}';
        validation('#create_notify_form', {
            'title': {
                required: true,
                maxlength : 255,
            },
            'content': {
                required: function(textarea) {
                    $("#content").attr('style', 'display: none !important');
                    CKEDITOR.instances['content'].updateElement(); // update textarea content
                    var editorcontent = textarea.value.replace(
                        /<[^>]*>/gi,
                        ""
                    );

                    return editorcontent.length === 0;
                }
            },
            'start_time': {
                required: true,
            },
            'status': {
                required: false,
            },
            'type': {
                required: true,
            },
        }, {
            'title': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter,
            },
            'content': {
                required: errorMessageRequired,
            },
            'start_time': {
                required: errorMessageRequired,
            },
            'status': {
                required: errorMessageRequired,
            },
            'type': {
                required: errorMessageRequired,
            },
        });
    </script>
    <script src="{{ url(mix('js/admin/notify/date_time.js')) }}"></script>
    <script src="{{ url(mix('js/ckeditor/ckeditor.js')) }}"></script>
    <script>
        $(document).ready(function() {
            if (sessionStorage.getItem("start_time")) {
                $("#start_time").val(sessionStorage.getItem("start_time"));
            }
            if (sessionStorage.getItem("end_time")) {
                $("#end_time").val(sessionStorage.getItem("end_time"));
            }
            sessionStorage.setItem("start_time", "");
            sessionStorage.setItem("end_time", "");

            $("#create_notify").on("click", function (){
                $(".form-check-label").css({color: '#3b4043'});
            });
            CKEDITOR.replace('content', {
                language: 'ja',
            });
            CKEDITOR.config.filebrowserUploadUrl = '{!! route('admin.upload-img', ['_token' => csrf_token()]) !!}';
        });
    </script>
@endsection
