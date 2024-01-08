@extends('admin.layouts.admin')
@section('title', __('labels.CM001_L028'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.analytics.index') }}" title="">{{__('labels.ANLT001_L001')}}</a></li>
                <li>{{__('labels.CM001_L028')}}</li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.CM001_L028')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <input type="hidden" name="search" value="1">
                                <input type="hidden" name="type" value="{{ $type ?? '' }}">
                                <div class="form-group mb-3 form-search">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ml-auto mb-2">
                                            <label>{{ __('labels.ANLT001_L018') }}</label>
                                            <div class="d-flex align-items-center">
                                                <input id="static_month" name="static_month" class="form-control" autocomplete="off" value="{{ $staticMonth ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xl-12 mt-3 d-flex justify-content-end">
                                            <button class="btn btn-primary float-right" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tb-scroll mt-4">
                                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                                <thead>
                                                <tr>
                                                    <form action="" method="get" id="form-sort">
                                                        <th class="tb-no">{{ __('ID') }}</th>
                                                        <th class="w-200px">{{ __('labels.ANLT001_L012') }}</th>
                                                        <th class="w-200px">{{ __('labels.ANLT001_L013') }}</th>
                                                        <th class="w-200px">{{ __('labels.ANLT001_L014') }}</th>
                                                        <th class="w-200px">{{ __('labels.ANLT001_L015') }}</th>
                                                        <th class="w-200px">{{ __('labels.ANLT001_L016') }}</th>
                                                        <th class="w-200px">{{ __('labels.COC001_L008') }}</th>
                                                    </form>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($data))
                                                        @foreach ($data as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $item->company }}</td>
                                                                <td>{{ \CommonHelper::formatPrice($item->order_amount) }}</td>
                                                                <td>{{ $item->bank_name }}</td>
                                                                <td>{{ $item->branch_name }}</td>
                                                                <td>{{ $item->bank_number }}</td>
                                                                <td>{{ $item->commission }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr role="row" class="odd">
                                                            <th colspan="100%" class="text-center">{{__('messages.H_MSG009')}}</th>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- pagination start -->
                                <div class="row mt-3">
                                    <div class="col-md-7"></div>
                                    <div class="col-sm-12 col-md-5 d-flex justify-content-end">
                                        <form action="{{ route('admin.analytics.export-file') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="static_month" value="{{ Request::get('static_month') }}">
                                            <button type="submit" class="btn btn-primary float-right">{{ __('labels.CM001_L024') }}</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="dataTables_paginate paging_simple_numbers float-left" id="example1_paginate">
                                            {{ $data->appends($params)->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- end pagination -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ url('js/highcharts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#static_month').datepicker( {
                language: 'ja',
                startView: "months",
                minViewMode: "months",
                format: 'yyyy-mm',
            });

            $('body').on('click', '[data-analytics]', function(e) {
                e.preventDefault();
                type = $(this).data('analytics');
                $(this).closest('form').find('input[name=type]').val(type);
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection
