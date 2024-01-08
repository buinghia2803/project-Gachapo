@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title="">{{ __('labels.CM001_L066') }}</a></li>
            </ul>
            @if ($message = Session::get('success'))
                <div class="p-2 alert alert-success pt-0 pb-0 message-booking">
                    <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                    <p class="mb-1">{{ $message }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.CM001_L067') }}</h3>
                        </div>

                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="m-profile__content">
                                    <!-- filter start -->
                                    <form action="{{ route('company.review.show') }}" method="GET">
                                        <div class="form-group mb-3 form-search">
                                            <div class="row mb-5">
                                                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                                    <label>{{ __('labels.ACA001_L006') }}</label>
                                                    <div class="d-flex align-items-center">
                                                        <input class="form-control" name="start_time_review"
                                                            autocomplete="off" id="start_date"
                                                            value="{{ Request::get('start_time_review') }}" />
                                                        <span class="ml-2 mr-2 fz-16px">~</span>
                                                        <input class="form-control" name="end_time_review"
                                                            autocomplete="off" id="end_date"
                                                            value="{{ Request::get('end_time_review') }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-2 col-xl-2 col-2 mt-4 ml-auto">
                                                    <button type="submit"
                                                        class="btn btn-primary float-right">{{ __('labels.CM001_L035') }}</button>
                                                </div>
                                            </div>
                                            <div class="row mb-2 col-sm-6">
                                                <label style="line-height: 45px">{{ __('labels.ADEL001_L002') }} /
                                                    {{ __('labels.CM001_L038') }}</label>
                                                <input class="form-control" name="id" placeholder="ID"
                                                    style="margin-left: 10px" value="{{ Request::get('id') }}" />
                                            </div>
                                        </div>
                                    </form>
                                    <!-- filter end -->
                                    <!-- table start -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"> {{ __('labels.COC001_L010') }}</th>
                                                <th scope="col" style="width: 60%;"> <span>
                                                        {{ __('labels.CM001_L032') }}</span></th>
                                                <th scope="col"> {{ __('labels.CM001_L068') }}</th>
                                                <th scope="col"> {{ __('labels.CM001_L022') }}</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="loadReview">
                                            @if (count($reviews) > 0)
                                                @foreach ($reviews as $review)
                                                    <tr>
                                                        <th scope="row"> {{ $review->id }}</th>
                                                        <td>
                                                            <span class="text-overflow-ellipsis">
                                                                {{ $review->content }}</span>
                                                        </td>
                                                        <td>{{ $review->order->user->name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($review->created_at)->format('Y年m月d日') }}
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ route('company.review.detail', $review->id) }}">{{ __('labels.AC001_B001') }}</a>
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
                                    <div id="post_data"></div>
                                    <!-- table end -->
                                    <div id="load_more">
                                        <input type="hidden" value="1" id="page">
                                        <a href="javascript:;" name="load_more_button" id="btn-loadmore"
                                            class="d-flex justify-content-center ajax-load" style="margin-top: 30px"
                                            onclick="loadMoreData()">
                                            Load More
                                        </a>
                                    </div>

                                </div>

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
    <script type="text/javascript">
        let page = 1
        $(document).ready(function() {
            // loadMoreData()
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ja',
            });
            $('#end_date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ja',
            });
        });

        function loadMoreData() {
            page++
            $.ajax({
                    url: '/company/load-more?page=' + page,
                    type: 'get',
                    beforeSend: function() {
                        $(".ajax-load").show();
                    }
                })
                .done(function(data) {
                    if (!data.html) {
                        $('.ajax-load').html("No more records found");
                        $('#btn-loadmore').hide()
                        return;
                    }
                    $('.ajax-load').hide();
                    $("#loadReview").append(data.html);

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert("Server not responding...");
                });
        }
    </script>

@endsection
