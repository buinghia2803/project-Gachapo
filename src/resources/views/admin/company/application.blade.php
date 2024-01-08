@extends('admin.layouts.admin')
@section('title', __('labels.ACA001_L001'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.company-application.index') }}" title="">{{__('labels.ACA001_L001')}}</a></li>
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
                        <h3 class="card-title">{{__('labels.ACA001_L001')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row form-search mb-4">
                                <input type="hidden" name="search" value="1">
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{ __('labels.COC001_L010') }}</label>
                                    <input class="form-control" name="id" placeholder="{{ __('labels.COC001_L010') }}" value="{{ Request::get('id') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{ __('labels.COC001_L003') }}</label>
                                    <input class="form-control" name="company" placeholder="{{ __('labels.COC001_L003') }}" value="{{ Request::get('company') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-6">
                                    <label>{{ __('labels.ACA001_L006') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control" name="start_time" autocomplete="off" id="start_time" value="{{ Request::get('start_time') }}" />
                                        <span class="ml-2 mr-2 fz-16px">~</span>
                                        <input class="form-control" name="end_time" autocomplete="off" id="end_time" value="{{ Request::get('end_time') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
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
                                                    <th class="w-70px mw-70px">
                                                        {{ __('labels.COC001_L010') }}
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="id"></i>
                                                    </th>
                                                    <th class="mw-200px">{{ __('labels.COC001_L003') }}</th>
                                                    <th class="mw-200px">{{ __('labels.COC001_L007') }}</th>
                                                    <th class="mw-200px">{{ __('labels.ACA001_L005') }}</th>
                                                    <th class="w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>
                                                    <th class="w-100px mw-100px">{{ __('labels.CM001_L031') }}<i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="status_approve"></i></th>
                                                    <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                    <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                    <input type="hidden" name="company" value="{{ Request::get('company') }}"/>
                                                    <input type="hidden" name="start_time" value="{{ Request::get('start_time') }}"/>
                                                    <input type="hidden" name="end_time" value="{{ Request::get('end_time') }}"/>
                                                    <input type="hidden" name="sort_field" value="" id="input"/>
                                                    <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                </form>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->company }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->person_manager }}</td>
                                                        <td>{{ $item->created_at->format('Y年m月d日') }}</td>
                                                        <td>{{ $listStatusApprove[$item->status_approve] ?? '' }}</td>
                                                        <td class="tb-action">
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('admin.company-application.confirm-approve', $item->id) }}"
                                                                    class="btn btn-primary"
                                                                    style="margin-right: 0 !important;"
                                                                >
                                                                    {{ __('labels.CM001_L009') }}
                                                                </a>
                                                                <a href="javascript: void(0);"
                                                                    title=""
                                                                    data-toggle="modal"
                                                                    class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                    data-target="#modal-delete"
                                                                    data-id="{{ $item->id }}"
                                                                    data-content="{{__('labels.CM001_L018',['title' => $item->company])}}"
                                                                    data-delete-url="{{ route('admin.company.destroy', $item->id) }}"
                                                                >
                                                                    {{ __('labels.CM001_L005') }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if (count($datas) == 0)
                                                    <tr role="row" class="odd">
                                                        <th colspan="100%" class="text-center">{{__('messages.H_MSG009')}}</th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    {{ $datas->appends(request()->all())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{__('labels.CM001_L014')}}</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text-delete"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.CM001_L013')}}</button>
                <button type="button" class="btn btn-danger delete">{{__('labels.CM001_L005')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
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
        });
    </script>
@endsection
