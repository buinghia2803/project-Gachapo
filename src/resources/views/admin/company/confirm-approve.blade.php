@extends('admin.layouts.admin')
@section('title', __('labels.ACA001_L001'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.company-application.index') }}" title="">{{__('labels.ACA001_L001')}}</a></li>
            <li><span>{{__('labels.ACA001_L007')}}</span></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.ACA001_L001')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L003' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->company ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L004' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->company_furigana ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L005' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->person_manager ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L006' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->person_manager_furigana ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L007' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->email ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.CM001_L019' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ '********' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.CM001_L020' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ '********' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L017' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->company_address ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.CM001_L025' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->phone ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L018' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->site_url ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L019' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $data->company_information ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.COC001_L020' )}}<br>{{__( 'labels.COC001_L021' )}}</label>
                                <div class="col-12 col-md-8">
                                    @if (empty($data->registered_copy_attachment))
                                        <p class="confirm_info">{{ $data->registered_copy_attachment ?? '--' }}</p>
                                    @else
                                        <a href="{{ asset($data->registered_copy_attachment ?? '') }}" class="btn btn-primary" download>{{ __('labels.CM001_L024') }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.ACA001_L011' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{__( 'labels.ACA001_L012' )}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8 d-flex">
                                    <button
                                        type="button"
                                        class="btn btn-danger mr-4"
                                        data-toggle="modal"
                                        data-target="#modal-approve"
                                    >{{__('labels.ACA001_L004')}}</button>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-disapprove"
                                    >{{__('labels.ACA001_L008')}}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-approve">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{__('labels.CM001_L016')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text-delete mb-0">{{__('labels.ACA001_L009')}}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.company.approve', $data->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{__('OK')}}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.CM001_L013')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-disapprove">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{__('labels.CM001_L016')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text-delete mb-0">{{__('labels.ACA001_L010')}}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.company.disapprove', $data->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{__('OK')}}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.CM001_L013')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection
