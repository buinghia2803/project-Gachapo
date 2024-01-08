@extends('company.layouts.company')
@section('title', __('labels.ANLT001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('company.analytics.index') }}" title="">{{__('labels.ANLT001_L001')}}</a></li>
                <li>{{__('labels.ANLT001_L001')}}</li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.ANLT001_L001')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="GET">
                                <div class="form-group mb-3">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2 d-flex">
                                            <input class="form-control" name="choose_date_pdf" id="choose_date_pdf" autocomplete="off" placeholder="2022年2月の売り上げ"/>
                                            <button type="button" id="download-pdf" class="ml-3 border-0 bg-white fs-1">{{__('labels.CAL001_L006')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="" method="GET">
                                <input type="hidden" name="search" value="1">
                                <input type="hidden" name="type" value="{{ $type ?? '' }}">
                                <div class="form-group mb-3 form-search">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                                            <label>{{ __('labels.ACA001_L006') }}</label>
                                            <div class="d-flex align-items-center">
                                                <input class="form-control" name="start_time" autocomplete="off" id="start_time" value="{{ $startTime ?? '' }}" />
                                                <span class="ml-2 mr-2 fz-16px">~</span>
                                                <input class="form-control" name="end_time" autocomplete="off" id="end_time" value="{{ $endTime ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-3 mt-4">
                                            <button class="btn btn-primary ml-auto" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 d-flex flex-wrap">
                                        <button type="button" data-analytics="{{ ANALYTIC_DEFAULT }}" class="btn {{ ($type == ANALYTIC_DEFAULT) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L002') }}</button>
                                        <button type="button" data-analytics="{{ ANALYTIC_GACHA }}" class="btn {{ ($type == ANALYTIC_GACHA) ? 'btn-info' : 'btn-primary' }} mr-3 mb-2">{{ __('labels.ANLT001_L004') }}</button>
                                        <button type="submit" formaction="{{ route('company.analytics.download-csv') }}" class="btn btn-default mr-3 mb-2">{{ __('labels.ANLT001_L006') }}</button>
                                    </div>
                                </div>
                            </form>
                            @switch($type)
                                @case(ANALYTIC_DEFAULT)
                                    <div class="row mt-5">
                                        <div class="col-sm-12">
                                            @if ((isset($data['data']) && isset($data['data'][0]) && !$data['data'][0] && !count($data['data'])) || !count($data))
                                                <p style="font-size: 16px;">{{__('messages.H_MSG009')}}</p>
                                            @else
                                                <div id="chart"></div>
                                            @endif
                                        </div>
                                    </div>
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
                            @endswitch
                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <p class="monthly-revenue">{{ __('labels.CAL001_L001') }}</p>
                                    <hr>
                                    <div class="d-flex">
                                        <div class="mr-5">
                                            <p class="monthly-revenue">{{ __('labels.CAL001_L002') }}</p>
                                            <p class="monthly-revenue">{{ __('labels.CAL001_L003') }}</p>
                                            <p class="monthly-revenue">{{ __('labels.CAL001_L004') }}</p>
                                        </div>
                                        <div>
                                            <p class="monthly-revenue">{{ \CommonHelper::formatPrice($currentRevenue['totalPrice'], '', '¥') }}</p>
                                            <p class="monthly-revenue">{{ $currentRevenue['totalGacha'] }}点</p>
                                            <p class="monthly-revenue">{{ \CommonHelper::formatPrice($currentRevenue['actualRevenue'], '', '¥') }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            @if(count($newestReview))
                                <div class="row mt-5">
                                    <div class="col-sm-12">
                                        <p class="review-none-rep">{{ __('labels.CAL001_L005') }}</p>
                                        <div class="mb-3 review-content-wrap">
                                            @foreach($newestReview as $review)
                                                <div class="d-flex mb-2 mt-2 justify-content-between">
                                                    <div class="ml-2 review-none-rep review-content">{{ $review->content }}</div>
                                                    <div class="mr-2 ml-3 review-none-rep w-150px">{{ ($review->order && $review->order->user) ? $review->order->user->name : '' }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="float-right" href="{{ route('company.review.show') }}">{{ __('labels.GAC001_L037') }}</a>
                                    </div>
                                </div>
                            @endif
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

            $('#choose_date_pdf').datepicker(
                {
                    format: 'yyyy/mm',
                    language: 'ja',
                    endDate: '+0m',
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
    @if($type === ANALYTIC_DEFAULT)
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
                            format: '{value}万'
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
