@extends('admin.layouts.admin')
@section('title', __('labels.ACPL001_L003'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.coupon.index') }}" title="">{{__('labels.ACPL001_L003')}}</a></li>
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
                        <h3 class="card-title">{{__('labels.ACPL001_L003')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupon.index') }}" method="GET">
                            <div class="row mb-4 form-search">
                                <div class="col-sm-6 col-xl-3">
                                    <label>ID</label>
                                    <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{__('labels.ACPL001_L007')}}</label>
                                    <input class="form-control" name="code" placeholder="クーポンコード" value="{{ Request::get('code') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-6">
                                    <label>{{__('labels.ACPL001_L002')}}</label>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control" name="period_start" autocomplete="off" id="period_start" value="{{ Request::get('period_start') }}" />
                                        <span class="ml-2 mr-2 fz-16px">~</span>
                                        <input class="form-control" name="period_end" autocomplete="off" id="period_end" value="{{ Request::get('period_end') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                    <button type="button" id="create-coupon" class="btn btn-primary">{{ __('labels.CM001_L006') }}</button>
                                </div>
                            </div>
                        </form>
                        <div id="" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tb-scroll mt-4 table-responsive">
                                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                            <thead>
                                            <tr>
                                                <form action="" method="get" id="form-sort">
                                                    <th class="w-70px mw-70px">
                                                        ID
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="id"></i>
                                                    </th>
                                                    <th class="mw-200px">{{ __('labels.ACPL001_L004') }}</th>
                                                    <th class="mw-200px">{{ __('labels.ACPL001_L005') }}</th>
                                                    <th class="mw-250px">{{ __('labels.ACPL001_L002') }}</th>
                                                    <th class="w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>
                                                    <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                    <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                    <input type="hidden" name="code" value="{{ Request::get('code') }}"/>
                                                    <input type="hidden" name="period_start" value="{{ Request::get('period_start') }}"/>
                                                    <input type="hidden" name="period_end" value="{{ Request::get('period_end') }}"/>
                                                    <input type="hidden" name="sort_field" value="" id="input"/>
                                                    <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                </form>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($coupons) > 0)
                                                @foreach($coupons as $coupon)
                                                    <tr>
                                                        <td><div>{{ $coupon->id }}</div></td>
                                                        <td>
                                                            <div>{!! $coupon->name . '</br>コード： ' . $coupon->code !!}</div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                @if($coupon->type_discount == COUPON_TYPE_PERCENT)
                                                                    <span>{{ __('labels.ACPL001_L010') }}</span>{{ $coupon->discount_rate }} <span>%</span>
                                                                @elseif($coupon->type_discount == COUPON_TYPE_PRICE)
                                                                    <span>{{ __('labels.ACPL001_L011') }}</span>{{ $coupon->discount_amount }} <span>{{ __('labels.ACPL001_L006') }}</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="tb-date ">
                                                            <span>{{ $coupon->period_start ? \Carbon\Carbon::parse($coupon->period_start)->format('Y年m月d日') : '' }}</span>
                                                            ～
                                                            <span>{{ $coupon->period_end ? \Carbon\Carbon::parse($coupon->period_end)->format('Y年m月d日') : ''}}</span>
                                                        </td>
                                                        <td class="tb-date">
                                                            {{ $coupon->created_at ? \Carbon\Carbon::parse($coupon->created_at)->format('Y年m月d日') : ''}}
                                                        </td>
                                                        <td class="tb-action">
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-primary" style="margin-right: 0 !important;">
                                                                    {{ __('labels.CM001_L009') }}
                                                                </a>
                                                                <a href="javascript: void(0);"
                                                                title=""
                                                                data-toggle="modal"
                                                                class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                data-target="#modal-delete"
                                                                data-id="{{ $coupon->id }}"
                                                                data-content="{{__('labels.CM001_L018',['title' => $coupon->name])}}"
                                                                data-delete-url="{{ route('admin.coupon.destroy', $coupon->id) }}">
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
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="dataTables_paginate paging_simple_numbers float-left" id="example1_paginate">
                                        {{ $coupons->appends($params)->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $('#period_start').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    language: 'ja',
                }
            );
            $('#period_end').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    language: 'ja',
                }
            );

            let token = $('meta[name="csrf-token"]').attr('content');
            $("#create-coupon").click(function(){
                $.ajax({
                method: 'GET',
                url: "coupon/generate-coupon-code",
                data_type: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                success: function(data) {
                    sessionStorage.setItem("couponCode", data.data);
                    window.location.href = 'coupon/create';
                    return;
                },
                error: function (data) {
                    location.reload();
                }
            });
            });
        });
    </script>
@endsection
