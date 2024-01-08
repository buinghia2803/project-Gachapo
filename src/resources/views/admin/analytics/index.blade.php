@extends('admin.layouts.admin')
@section('title', __('labels.ANLT001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.analytics.index') }}" title="">{{__('labels.ANLT001_L001')}}</a></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.ANLT001_L001')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <input type="hidden" name="search" value="1">
                                <input type="hidden" name="type" value="{{ $type ?? '' }}">
                                <div class="row mb-4 form-search">
                                    <div class="col-sm-6 col-xl-6">
                                        <label>{{ __('labels.ACA001_L006') }}</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" name="start_time" autocomplete="off" id="start_time" value="{{ $startTime ?? '' }}" />
                                            <span class="ml-2 mr-2 fz-16px">~</span>
                                            <input class="form-control" name="end_time" autocomplete="off" id="end_time" value="{{ $endTime ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 d-flex flex-wrap">
                                        <button class="btn btn-primary mr-3 mb-2" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                        <button type="button" data-analytics="{{ ANALYTIC_DEFAULT }}" class="btn {{ ($type == ANALYTIC_DEFAULT) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L002') }}</button>
                                        <button type="button" data-analytics="{{ ANALYTIC_CATEGORY }}" class="btn {{ ($type == ANALYTIC_CATEGORY) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L003') }}</button>
                                        <button type="button" data-analytics="{{ ANALYTIC_GACHA }}" class="btn {{ ($type == ANALYTIC_GACHA) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L004') }}</button>
                                        <button type="button" data-analytics="{{ ANALYTIC_COMPANY }}" class="btn {{ ($type == ANALYTIC_COMPANY) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L005') }}</button>
                                        <button type="submit" formaction="{{ route('admin.analytics.download') }}" class="btn btn-default mr-3 mb-2">{{ __('labels.ANLT001_L006') }}</button>
                                        <a  href="{{ route('admin.analytics.detail') }}" class="btn btn-default mr-3 mb-2">{{ __('labels.ANLT001_L007') }}</a>
                                    </div>
                                </div>
                            </form>
                            @switch($type)
                                @case(ANALYTIC_DEFAULT)
                                @case(ANALYTIC_CATEGORY)
                                    @if($isShow)
                                        <div class="row mt-5">
                                            <div class="col-sm-12">
                                                @if (isset($data['data']) && isset($data['data'][0]) && !$data['data'][0] && !count($data['data']))
                                                    <p style="font-size: 16px;">{{__('messages.H_MSG009')}}</p>
                                                @else
                                                    <div id="chart"></div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mt-5">
                                            <div class="col-sm-12 border d-flex justify-content-center align-items-center" style="height: 400px">
                                                {{ __('messages.H_MSG009') }}
                                            </div>
                                        </div>
                                    @endif
                                @break
                                @case(ANALYTIC_GACHA)
                                    <div id="" class="dataTables_wrapper dt-bootstrap4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="tb-scroll mt-4">
                                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                                        <thead>
                                                        <tr>
                                                            <form action="" method="get" id="form-sort">
                                                                <th class="tb-no">{{ __('ID') }}</th>
                                                                <th class="w-200px">{{ __('labels.ANLT001_L009') }}</th>
                                                                <th class="w-200px">{{ __('labels.ANLT001_L010') }}</th>
                                                            </form>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data as $item)
                                                                <tr>
                                                                    <td>{{ $item->id }}</td>
                                                                    <td>
                                                                        <p class="line line-2">{{ $item->getName() }}</p>
                                                                    </td>
                                                                    <td>{{ \CommonHelper::formatPrice($item->order_amount) }}</td>
                                                                </tr>
                                                            @endforeach
                                                            @if (count($data) == 0)
                                                                <tr role="row" class="odd">
                                                                    <th colspan="100%" class="text-center">{{__('messages.H_MSG009')}}</th>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @break
                                @case(ANALYTIC_COMPANY)
                                    <div id="" class="dataTables_wrapper dt-bootstrap4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="tb-scroll mt-4">
                                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                                        <thead>
                                                        <tr>
                                                            <form action="" method="get" id="form-sort">
                                                                <th class="tb-no">{{ __('ID') }}</th>
                                                                <th class="w-200px">{{ __('labels.ANLT001_L011') }}</th>
                                                                <th class="w-200px">{{ __('labels.ANLT001_L010') }}</th>
                                                            </form>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td>{{ $item->id }}</td>
                                                                <td>
                                                                    <p class="line line-2">{{ $item->company }}</p>
                                                                </td>
                                                                <td>{{ \CommonHelper::formatPrice($item->order_amount) }}</td>
                                                            </tr>
                                                        @endforeach
                                                        @if (count($data) == 0)
                                                            <tr role="row" class="odd">
                                                                <th colspan="100%" class="text-center">{{__('messages.H_MSG009')}}</th>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @break
                            @endswitch
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
            $('#start_time').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    language: 'ja',
                }
            );
            $('#end_time').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    language: 'ja',
                }
            );
            $('body').on('click', '[data-analytics]', function(e) {
                e.preventDefault();
                type = $(this).data('analytics');
                $(this).closest('form').find('input[name=type]').val(type);
                $(this).closest('form').submit();
            });
        });
    </script>
    @if(in_array($type, [ ANALYTIC_DEFAULT, ANALYTIC_CATEGORY ]))
        <script type="text/javascript">
            $(document).ready(function () {
                Highcharts.chart('chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: JSON.parse('{!! json_encode($data['categories'] ?? []) !!}'),
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        labels: {
                            format: `{value}万`
                        },
                        title: {
                            text: '{{__('labels.ANLT001_L008')}}'
                        }
                    },
                    series: [{
                        name: '',
                        data: JSON.parse('{!! json_encode($data['data'] ?? []) !!}'),
                    }]
                });
                $('.highcharts-credits').css('display', 'none');
            });
        </script>
    @endif
@endsection
