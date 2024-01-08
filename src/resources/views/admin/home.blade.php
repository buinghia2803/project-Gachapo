@extends('admin.layouts.admin')
@section('title', __('labels.CDB001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.CDB001_L001')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>{{__('labels.CDB001_L001')}}</h4>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
