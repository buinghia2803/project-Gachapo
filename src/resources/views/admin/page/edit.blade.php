@extends('admin.layouts.admin')
@section('title', __('labels.APM001_L011'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/pages" title="">{{ __('labels.APM001_L001') }}</a></li>
                <li><span>{{ __('labels.CM001_L009') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.APM001_L011') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('admin.pages.update', $page->id) }}" id="update_page_form" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="id" value={{ $page->id }}>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="title" class="col-12 col-md-4">{{ __("labels.APM001_L009") }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="title" class="form-control"
                                                    id="title" placeholder="{{__('labels.AC001_CN001')}}" value="{{ old('title', $page->title) }}">
                                                @error('title')
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
                                            <label for="slug" class="col-12 col-md-4">{{ __("labels.AC001_CS001") }}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="slug" class="form-control"
                                                    id="slug" placeholder="{{__('labels.AC001_CS001')}}" value="{{ old('slug', $page->slug) }}">
                                                @error('slug')
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
                                        <div class="row">
                                            <label for="slug" class="col-12 col-md-4">{{__('labels.CM001_L032')}}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <textarea id="content" name="content" class="form-control textarea-editor" data-input='editor'
                                                        cols="15">
                                                    {!! old('content', $page->content) !!}
                                                </textarea>
                                                <div class="textarea-error"></div>
                                                @error('content')
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
                                            <label for="status" class="col-12 col-md-4">{{__('labels.CM001_L031')}}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <select class="form-control" name="status" style="min-width: 215px">
                                                    @foreach ($statusList as $key => $item)
                                                        <option value="{{ $key }}" {{ old('status', $page->status) == $key ? 'selected' : '' }} >{{ $item }}</option>
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
                                            <label for="type" class="col-12 col-md-4">{{__('labels.APM001_L010')}}<span
                                                    class="required">*</span></label>
                                            <div class="col-12 col-md-8">
                                                <select class="form-control" name="type" style="min-width: 215px">
                                                    @foreach ($listUnusedType as $key => $item)
                                                        <option value="{{ $key }}" {{ old('type', $page->type) == $key ? 'selected' : '' }} >{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                @error('type')
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
                                                        class="btn btn-primary">{{__('labels.CM001_L002')}}</button>
                                                <a href="{{route('admin.pages.index')}}"
                                                    class="btn btn-secondary ml-0 ml-3">{{__('labels.CM001_L013')}}
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
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';

        validation('#update_page_form', {
            'title': {
                required: true,
                maxlength : 255
            },
            'slug': {
                required: true,
                maxlength : 255
            },
            'content': {
                required: function(textarea) {
                    $("#content").attr('style', 'display: none !important');
                    CKEDITOR.instances['content'].updateElement();
                    var editorcontent = textarea.value.replace(
                        /<[^>]*>/gi,
                        ""
                    );

                    return editorcontent.length === 0;
                }
            },
            'status': {
                required: true,
            },
            'type': {
                required: true,
            },
        }, {
            'title': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'slug': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxCharacter
            },
            'content': {
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
    <script src="{{ url(mix('js/ckeditor/ckeditor.js')) }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('content', {
                language: 'ja',
            });
        });
        CKEDITOR.config.filebrowserUploadUrl = '{!! route('admin.upload-img', ['_token' => csrf_token()]) !!}';
    </script>
@endsection
