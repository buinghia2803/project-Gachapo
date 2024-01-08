@extends('company.layouts.company')
@section('title', __('labels.CNL001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="{{ route('company.notify.index') }}" title="">{{__('labels.CNL001_L001')}}</a></li>
                    <li>{{__('labels.CNL001_L002')}}</li>
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
                                <h3 class="card-title">{{__('labels.CNL001_L001')}}</h3>
                            </div>
                            <!-- body start -->
                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
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
                                                                <th class="tb-date mw-300px">{{ __('labels.NML001_L004') }}</th>
                                                                <th class="mw-100px">{{ __('labels.CM001_L033') }}</th>
                                                                <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                                <input type="hidden" name="sort_field" value="" id="input"/>
                                                                <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                            </form>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($notifies) > 0)
                                                            @foreach($notifies as $index => $notify)
                                                                <tr>
                                                                    <td class="tb-date">
                                                                        <span>{{ \Carbon\Carbon::parse($notify->start_time)->format('Y年m月d日')}}</span>
                                                                        ～
                                                                        <span>{{ $notify->end_time ? \Carbon\Carbon::parse($notify->end_time)->format('Y年m月d日') : __("labels.NMC001_L008")}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-overflow-ellipsis row-2">
                                                                            {{ $notify->title }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="tb-action">
                                                                        <div class="d-flex align-items-center d-flex justify-content-center">
                                                                            <a href="{{ route('company.notify.show', $notify->id) }}" class="btn btn-primary" style="margin-right: 0 !important;">
                                                                                {{ __('labels.CM001_L028') }}
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
                                        <div class="col-sm-12 col-md-7 pagination-wrap">
                                            <div class="dataTables_paginate paging_simple_numbers float-left" id="pagination-content">
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
@endsection
