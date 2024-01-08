@extends('admin.layouts.admin')
@section('title', __('labels.ADEL001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/delivery" title="">{{ __('labels.ADEL001_L001') }}</a></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            @if ($message = Session::get('success'))
                <div class="p-2 alert alert-success pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="p-2 alert alert-danger pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{ $message }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.ADEL001_L001') }}</h3>
                        </div>
                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <!-- filter start -->
                                <form action="{{ route('admin.delivery.index') }}" method="GET">
                                    <div class="row mb-4 form-search">
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.ADEL001_L002') }}</label>
                                            <input class="form-control" name="id" placeholder="ID"
                                                value="{{ Request::get('id') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.COC001_L003') }}</label>
                                            <input class="form-control" name="company_name"
                                                placeholder="{{ __('labels.COC001_L003') }}"
                                                value="{{ Request::get('company_name') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.CM001_L038') }}</label>
                                            <input class="form-control" name="user_name"
                                                placeholder="{{ __('labels.CM001_L038') }}"
                                                value="{{ Request::get('user_name') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.ADEL001_L003') }}</label>
                                            <select class="form-control" name="status_deliver">
                                                <option value="">{{ __('labels.CM001_L012') }}</option>
                                                @foreach ($statusList as $key => $item)
                                                    <option value="{{ $key }}"
                                                        {{ Request()->status_deliver == $key ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label>{{ __('labels.ACA001_L006') }}</label>
                                            <div class="d-flex align-items-center">
                                                <input class="form-control" name="start_date" autocomplete="off" id="start_date" value="{{ Request::get('start_date') }}" />
                                                <span class="ml-2 mr-2 fz-16px">~</span>
                                                <input class="form-control" name="end_date" autocomplete="off" id="end_date" value="{{ Request::get('end_date') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-sm-12 d-flex">
                                                <button type="submit" class="btn btn-primary mr-4">{{ __('labels.CM001_L035') }}</button>
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
                                                            <th class="tb-no w-100px mw-100px">
                                                                {{ __('labels.ADEL001_L002') }}<i
                                                                    class="fas fa-sort mt-1 float-right sort-data"
                                                                    desc="{{ Request::get('sort_type') }}"
                                                                    content-value="id"></i></th>
                                                            <th class="w-150px mw-150px">{{ __('labels.CM001_L038') }}
                                                            </th>
                                                            <th class="w-150px mw-150px">{{ __('labels.GAC001_L016') }}
                                                            </th>
                                                            <th class="tb-date w-150px mw-150px">
                                                                {{ __('labels.ADEL001_L004') }}<i
                                                                    class="fas fa-sort mt-1 float-right sort-data"
                                                                    desc="{{ Request::get('sort_type') }}"
                                                                    content-value="created_at"></i></th>
                                                            <th class="tb-date w-150px mw-150px">
                                                                {{ __('labels.ADEL001_L005') }}<i
                                                                    class="fas fa-sort mt-1 float-right sort-data"
                                                                    desc="{{ Request::get('sort_type') }}"
                                                                    content-value="date_of_shipment"></i></th>
                                                            <th class="w-150px mw-150px">
                                                                {{ __('labels.ADEL001_L003') }}<i
                                                                    class="fas fa-sort mt-1 float-right sort-data"
                                                                    desc="{{ Request::get('sort_type') }}"
                                                                    content-value="status_deliver"></i></th>
                                                            <th class="text-center">{{ __('labels.CM001_L011') }}</th>
                                                            <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                            <input type="hidden" name="company_name" value="{{ Request::get('company_name') }}"/>
                                                            <input type="hidden" name="user_name" value="{{ Request::get('user_name') }}"/>
                                                            <input type="hidden" name="status_deliver" value="{{ Request::get('status_deliver') }}"/>
                                                            <input type="hidden" name="start_date" value="{{ Request::get('start_date') }}"/>
                                                            <input type="hidden" name="end_date" value="{{ Request::get('end_date') }}"/>
                                                            <input type="hidden" name="sort_field" value="" id="input" />
                                                            <input type="hidden" name="sort_type" value="" id="typeSort" />
                                                        </form>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($deliveries) > 0)
                                                        @foreach ($deliveries as $index => $delivery)
                                                            <tr>
                                                                <td class="tb-no">
                                                                    <div>{{ $delivery->id }}</div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-overflow-ellipsis row-2">
                                                                        {{ $delivery->user ? $delivery->user->name : '' }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-overflow-ellipsis row-2">
                                                                        @if ($delivery->orderDetails && count($delivery->orderDetails) > 0)
                                                                            @foreach ($delivery->orderDetails as $key => $orderDetail)
                                                                                @if ($key < 1)
                                                                                {{ $orderDetail->product->name . (count($delivery->orderDetails) >= 2 ? "," : "") }}
                                                                                @elseif ($key == 1)
                                                                                {{ $orderDetail->product->name . (count($delivery->orderDetails) > 2 ? "..." : "") }}
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="tb-date">
                                                                    <div>
                                                                        {{ \Carbon\Carbon::parse($delivery->created_at)->format('Y/m/d') }}
                                                                    </div>
                                                                </td>
                                                                <td class="tb-date">
                                                                    <div>
                                                                        {{ \Carbon\Carbon::parse($delivery->date_of_shipment)->format('Y/m/d') }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        {{ $statusList[$delivery->status_deliver] }}
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div>
                                                                        <a href="{{ route('admin.delivery.show', $delivery->id) }}"
                                                                            class="btn btn-primary"
                                                                            style="margin-right: 0 !important;">
                                                                            {{ __('labels.ADEL001_L006') }}
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        @if (request()->get('search'))
                                                            <tr role="row" class="odd">
                                                                <th colspan="10" class="text-center">
                                                                    {{ __('messages.H_MSG004') }}</th>
                                                            </tr>
                                                        @else
                                                            <tr role="row" class="odd">
                                                                <th colspan="10" class="text-center">
                                                                    {{ __('messages.H_MSG009') }}</th>
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
                                <div class="row mt-3">
                                    <div class="col-md-7"></div>
                                    <div class="col-sm-12 col-md-5 d-flex justify-content-end">
                                        <form action="{{ route('admin.delivery.export-file') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ Request::get('id') }}">
                                            <input type="hidden" name="company_name" value="{{ Request::get('company_name') }}">
                                            <input type="hidden" name="user_name" value="{{ Request::get('user_name') }}">
                                            <input type="hidden" name="status_deliver" value="{{ Request::get('status_deliver') }}">
                                            <input type="hidden" name="start_date" value="{{ Request::get('start_date') }}">
                                            <input type="hidden" name="end_date" value="{{ Request::get('end_date') }}">
                                            <button type="submit"
                                                class="btn btn-primary float-right">{{ __('labels.CM001_L024') }}</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers float-left"
                                            id="example1_paginate">
                                            {{ $deliveries->appends($params)->links() }}
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

@section('javascript')
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ja',
            });
            $('#end_date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ja',
            });
        });
    </script>
@endsection
