@extends('company.layouts.company')
@section('title', __('labels.CNL001_L001'), $notify->title)
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="{{ route('company.notify.index') }}" title="">{{__('labels.CNL001_L001')}}</a></li>
                    <li>{{__('labels.CNL001_L002')}}</li>
                    <li>{{$notify->title}}</li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{$notify->title}}</h3>
                            </div>
                            <!-- body start -->
                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4" style="font-size: 2em">
                                    {!! $notify->content !!}
                                </div>
                            </div>
                            <!-- body end -->
                            <div class="d-flex align-items-center d-flex justify-content-center mt-5">
                                <a class="btn btn-primary" onclick="back()">{{__("labels.CM001_L017")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function back() {
            history.back();
        }
    </script>
@endsection
