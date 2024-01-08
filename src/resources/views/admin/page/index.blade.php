@extends('admin.layouts.admin')
@section('title', __('labels.APM001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/category" title="">{{__('labels.APM001_L001')}}</a></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            @if (Session::get('deleted_success') == true)
                <div class="alert alert-success alert-dismissible message-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{__('messages.CM001_L007')}}</p>
                </div>
                @php(Session::forget('deleted_success'))
            @elseif(Session::get('deleted_failed') == true)
                <div class="alert alert-error alert-dismissible message-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{__('messages.CM001_L010')}}</p>
                </div>
                @php(Session::forget('deleted_failed'))
            @endif
            @if ($message = Session::get('success'))
                <div
                    class="p-2 alert alert-success pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{$message}}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div
                    class="p-2 alert alert-danger pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{$message}}</p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.APM001_L001')}}</h3>
                        </div>
                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <!-- filter start -->
                                <form action="{{ route('admin.pages.index') }}" method="GET">
                                    <div class="row mb-4 form-search">
                                        <div class="col-sm-6 col-xl-3">
                                            <label>ID</label>
                                            <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.CM001_L033') }}</label>
                                            <input class="form-control" name="title" placeholder="{{ __('labels.CM001_L033') }}" value="{{ Request::get('title') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.CM001_L031') }}</label>
                                            <select class="form-control" name="status" style="min-width: 215px">
                                                <option value="">{{ __('labels.CM001_L012') }}</option>
                                                @foreach ($statusList as $key => $item)
                                                    <option value="{{ $key }}" {{ (Request()->status == $key) ? 'selected' : '' }} >{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-3"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex">
                                            <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                            <a href="{{ !$checkUnusedType ? 'javascript:void(0)' : route('admin.pages.create') }}" title="" class="btn {{ !$checkUnusedType ? 'btn-secondary' : 'btn-primary'}}">{{ __('labels.CM001_L006') }}</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- filter end -->
                                <!-- table start -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tb-scroll mt-4">
                                            <table id="example1"
                                                class="table table-bordered table-striped dataTable dtr-inline tb-user-list"
                                                role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr>
                                                    <form action="" method="get" id="form-sort">
                                                        <th class="tb-no">{{ __('ID') }}</th>
                                                        <th class="w-210px mw-250px">{{ __('labels.APM001_L009') }}</th>
                                                        <th class="w-100px mw-100px">{{ __('labels.CM001_L031') }}<i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="status"></i></th>
                                                        <th class="tb-date w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>
                                                        <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                        <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                        <input type="hidden" name="title" value="{{ Request::get('title') }}"/>
                                                        <input type="hidden" name="status" value="{{ Request::get('status') }}"/>
                                                        <input type="hidden" name="sort_field" value="" id="input"/>
                                                        <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                    </form>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (count($pages) > 0)
                                                    @foreach($pages as $index => $page)
                                                        <tr>
                                                            <td class="tb-no"><div>{{ $page->id }}</div></td>
                                                            <td><div class="text-overflow-ellipsis row-2">{{ $page->title }}</div></td>
                                                            <td><div>{{ $statusList[$page->status] }}</div></td>
                                                            <td class="tb-date"><div>{{ \Carbon\Carbon::parse($page->created_at)->format('Y年m月d日')}}</div></td>
                                                            <td class="tb-action">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary" style="margin-right: 0 !important;">
                                                                        {{ __('labels.CM001_L009') }}
                                                                    </a>
                                                                    <a href="javascript: void(0);"
                                                                        title=""
                                                                        data-toggle="modal"
                                                                        class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                        data-target="#modal-delete"
                                                                        data-id="{{ $page->id }}"
                                                                        data-content="{{__('labels.CM001_L018',['title' => $page->title])}}"
                                                                        data-delete-url="{{ route('admin.pages.destroy', $page->id) }}">
                                                                        {{ __('labels.CM001_L005') }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @if(request()->get('search'))
                                                        <tr role="row" class="odd">
                                                            <th colspan="10" class="text-center">{{__('messages.H_MSG004')}}</th>
                                                        </tr>
                                                    @else
                                                        <tr role="row" class="odd">
                                                            <th colspan="10" class="text-center">{{__('messages.H_MSG009')}}</th>
                                                        </tr>
                                                    @endif
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end table -->
                                <!-- pagination start -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers float-left" id="example1_paginate">
                                            {{ $pages->appends($params)->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- end pagination -->
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
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
@endsection
