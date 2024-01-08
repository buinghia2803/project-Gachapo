@extends('admin.layouts.admin')
@section('title', __('labels.AUM001_L001'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/user" title="">{{ __('labels.AUM001_L001') }}</a></li>
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
                            <h3 class="card-title">{{ __('labels.AUM001_L001') }}</h3>
                        </div>
                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <!-- filter start -->
                                <form action="{{ route('admin.user.index') }}" method="GET">
                                    <div class="row form-search mb-4">
                                        <div class="col-sm-6 col-xl-3">
                                            <label>ID</label>
                                            <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.ADM001_L002') }}</label>
                                            <input class="form-control" name="name" placeholder="{{ __('labels.ADM001_L002') }}" value="{{ Request::get('name') }}" />
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <label>{{ __('labels.CM001_L031') }}</label>
                                            <select class="form-control" name="status">
                                                <option value="">{{ __('labels.CM001_L012') }}</option>
                                                @foreach ($listStatus as $key => $item)
                                                    <option value="{{ $key }}" {{ (Request()->status == $key) ? 'selected' : '' }} >{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-3"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex">
                                            <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                            <a href="{{ route('admin.user.create') }}" title="" class="btn btn-primary">{{ __('labels.NML001_L003') }}</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- filter end -->
                                <!-- table start -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tb-scroll mt-4 table-responsive">
                                            <table id="example1"
                                                class="table table-bordered table-striped dataTable dtr-inline tb-user-list"
                                                role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr>
                                                    <form action="" method="get" id="form-sort">
                                                        <th class="tb-no custom-tb-id">{{ __('labels.AUM001_L004') }}<i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="id"></i></th>
                                                        <th class="w-400px mw-300px">{{ __('labels.ADM001_L002') }}</th>
                                                        <th>{{ __('labels.CM001_L030') }}</th>
                                                        <th class="w-100px mw-100px">{{ __('labels.CM001_L031') }}<i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('sort_type')}}" content-value="status"></i></th>
                                                        <th class="w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>
                                                        <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                        <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                        <input type="hidden" name="name" value="{{ Request::get('name') }}"/>
                                                        <input type="hidden" name="status" value="{{ Request::get('status') }}"/>
                                                        <input type="hidden" name="sort_field" value="" id="input"/>
                                                        <input type="hidden" name="sort_type" value="" id="typeSort"/>
                                                    </form>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($users) > 0)
                                                    @foreach($users as $index => $user)
                                                        <tr>
                                                            <td><div>{{ $user->id }}</div></td>
                                                            <td>
                                                                <div class="text-overflow-ellipsis custom-text row-2">{{ $user->name }}</div>
                                                            </td>
                                                            <td><div>{{ $user->email }}</div></td>
                                                            <td><div>{{ $listStatus[$user->status] }}</div></td>
                                                            <td><span>{{ \Carbon\Carbon::parse($user->created_at)->format('Y年m月d日')}}</span></td>
                                                            <td class="tb-action">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary" style="margin-right: 0 !important;">
                                                                        {{ __('labels.CM001_L009') }}
                                                                    </a>
                                                                    <a href="javascript: void(0);"
                                                                    title=""
                                                                    data-toggle="modal"
                                                                    class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                    data-target="#modal-delete"
                                                                    data-id="{{ $user->id }}"
                                                                    data-content="{{__('labels.CM001_L018',['title' => $user->name])}}"
                                                                    data-delete-url="{{ route('admin.user.destroy', $user->id) }}">
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
                                <!-- end table -->
                                <!-- pagination start -->
                                <div class="row mt-3">
                                    <div class="col-md-7"></div>
                                    <div class="col-sm-12 col-md-5 d-flex justify-content-end">
                                        <a href="user?status={{ BLACKLIST }}" class="btn btn-primary mr-3">{{ __('labels.COC001_L012') }}</a>
                                        <form action="{{ route('admin.user.export-file') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ Request::get('id') }}">
                                            <input type="hidden" name="name" value="{{ Request::get('name') }}">
                                            <input type="hidden" name="status" value="{{ Request::get('status') }}">
                                            <input type="hidden" name="address" value="{{ Request::get('address') }}">
                                            <button type="submit" class="btn btn-primary float-right">{{ __('labels.CM001_L024') }}</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="dataTables_paginate paging_simple_numbers float-left" id="example1_paginate">
                                            {{ $users->appends($params)->links() }}
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
@endsection
