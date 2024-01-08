@extends('admin.layouts.admin')
@section('title', __('labels.AC001_L002'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/category" title="">{{__('labels.AC001_L001')}}</a></li>
                    <li><span>{{__('labels.AC001_B001')}}</span></li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('labels.AC001_L002') }}</h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('admin.category.update', $category->id) }}" id="update_category_form" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="name" class="col-12 col-md-4">{{__('labels.AC001_CN001')}}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="name" class="form-control"
                                                        id="name" placeholder="{{__('labels.AC001_CN001')}}" value="{{ old('name', $category->name) }}">
                                                    @error('name')
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
                                                <label for="slug" class="col-12 col-md-4">{{__('labels.AC001_CS001')}}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="slug" class="form-control"
                                                        id="slug" placeholder="{{__('labels.AC001_CS001')}}" value="{{ old('slug', $category->slug) }}">
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
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4"></label>
                                                <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                    <button type="submit"
                                                            class="btn btn-primary">{{__('labels.AC001_B002')}}</button>
                                                    <a href="{{route('admin.category.index')}}"
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
    <script type="text/javascript">
        const errorMessageNameRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageNameMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
        const errorMessageSlugRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageSlugMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
    </script>
    <script src="{{ url(mix('js/admin/category/update_category_validation.js')) }}"></script>
@endsection
