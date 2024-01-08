@extends('admin.layouts.admin')
@section('title', __('labels.NML001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/notify" title="">{{ __('labels.NML001_L001') }}</a></li>
                </ul>
                {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
                @if (Session::get('deleted_success') == true)
                    <div class="alert alert-success alert-dismissible message-alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ __('messages.CM001_L007') }}</p>
                    </div>
                    @php(Session::forget('deleted_success'))
                @elseif(Session::get('deleted_failed') == true)
                    <div class="alert alert-error alert-dismissible message-alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ __('messages.CM001_L010') }}</p>
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
                                <h3 class="card-title">{{ __('labels.NML001_L001') }}</h3>
                            </div>
                            <!-- body start -->
                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <!-- filter start -->
                                    <form action="{{ route('admin.notify.index') }}" method="GET">
                                        <div class="row form-search mb-4">
                                            <div class="col-sm-6 col-xl-3">
                                                <label>ID</label>
                                                <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <label>{{ __('labels.NML001_L007') }}</label>
                                                <select class="form-control" name="status">
                                                    <option value="">{{ __('labels.CM001_L012') }}</option>
                                                    @foreach ($listStatus as $key => $item)
                                                        <option value="{{ $key }}" {{ (Request()->status == $key) ? 'selected' : '' }} >{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <label>{{ __('labels.NML001_L002') }}</label>
                                                <input class="form-control" name="start_time" autocomplete="off" id="start_time" value="{{ Request::get('start_time') }}" />
                                            </div>
                                            <div class="col-sm-6 col-xl-3"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 d-flex">
                                                <button class="btn btn-primary mr-4">{{ __('labels.CM001_L035') }}</button>
                                                <a href="{{ route('admin.notify.create') }}" title="" class="btn btn-primary">{{ __('labels.NML001_L003') }}</a>
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
                                                            <th class="tb-no">{{ __('ID') }} <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="id"></i></th>
                                                            <th class="tb-date w-250px mw-300px">{{ __('labels.NML001_L004') }}</th>
                                                            <th class="w-100px mw-100px">{{ __('labels.NML001_L005') }}</th>
                                                            <th class="w-100px mw-100px">{{ __('labels.CM001_L033') }}</th>
                                                            <th class="w-100px mw-100px">{{ __('labels.NML001_L007') }}</th>
                                                            <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                            <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                            <input type="hidden" name="status" value="{{ Request::get('status') }}"/>
                                                            <input type="hidden" name="start_time" value="{{ Request::get('start_time') }}"/>
                                                            <input type="hidden" name="sort_field" value="" id="input"/>
                                                            <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                        </form>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($notifies) > 0)
                                                        @foreach($notifies as $index => $notify)
                                                            <tr>
                                                                <td class="tb-no"><div>{{ $notify->id }}</div></td>
                                                                <td class="tb-date">
                                                                    <span>{{ \Carbon\Carbon::parse($notify->start_time)->format('Y年m月d日')}}</span>
                                                                    ～
                                                                    <span>{{ $notify->end_time ? \Carbon\Carbon::parse($notify->end_time)->format('Y年m月d日') : __("labels.NMC001_L008")}}</span>
                                                                </td>
                                                                <td><div>{{ $notify->type == USER ? '個人向け' : '企業向け' }}</div></td>
                                                                <td>
                                                                    <div class="text-overflow-ellipsis custom-text row-2">
                                                                        {{ $notify->title }}
                                                                    </div>
                                                                </td>
                                                                <td><div>{{ $notify->status == PUBLISH ? __('labels.NML001_L0010') : __('labels.NML001_L0011') }}</div></td>
                                                                <td class="tb-action">
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="{{ route('admin.notify.edit', $notify->id) }}" class="btn btn-primary" style="margin-right: 0 !important;">
                                                                            {{ __('labels.CM001_L009') }}
                                                                        </a>
                                                                        <a href="javascript: void(0);"
                                                                        title=""
                                                                        data-toggle="modal"
                                                                        class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                        data-target="#modal-delete"
                                                                        data-id="{{ $notify->id }}"
                                                                        data-content="{{__('labels.CM001_L018',['title' => $notify->title])}}"
                                                                        data-delete-url="{{ route('admin.notify.destroy', $notify->id) }}">
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
                                                {{ $notifies->appends($params)->links() }}
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#start_time').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    language: 'ja',
                }
            )
            .on('keyup', function() {
                if(this.value && this.value.match(/^\d{4}[^\d]\d{1,2}[^\d]\d{1,2}$/gi) == null) {
                    $('#start_time').val("");
                }
            });
        });
    </script>
@endsection
