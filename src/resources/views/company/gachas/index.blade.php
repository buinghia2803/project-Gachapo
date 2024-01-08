@extends('company.layouts.company')
@section('title', __('labels.GAC001_L003'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.GAC001_L003')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('company.gachas.index') }}" method="GET">
                            <input type="hidden" name="search" value="1">
                            <div class="form-group mb-3 form-search">
                                <div class="row mb-2">
                                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-2">
                                        <label>ID</label>
                                        <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                    </div>
                                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-2">
                                        <label>{{ __('labels.GAC001_L004') }}</label>
                                        <input class="form-control" name="name" placeholder="{{ __('labels.GAC001_L004') }}" value="{{ Request::get('name') }}" />
                                    </div>
                                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-2">
                                        <label>{{ __('labels.GAC001_L047') }}</label>
                                        <select class="form-control" name="status_operation">
                                            @foreach ($status_operation as $key => $item)
                                                <option value="{{ $key }}" {{ ((string)$key === Request::get('status_operation')) ? 'selected="selected"' : '' }}>{{ __($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-2">
                                        <label>{{ __('labels.ADM001_L003') }}</label>
                                        <select class="form-control" name="status">
                                            @foreach ($status as $key => $item)
                                                <option value="{{ $key }}" {{ ($key == Request::get('status')) ? 'selected="selected"' : '' }} >{{ __($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <a href="{{ route('company.gachas.create') }}" class="btn btn-primary mr-3">{{ __('labels.CM001_L006') }}</a>
                                    <button
                                        id="delete-all"
                                        type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-delete-all"
                                        data-content="{{__('labels.GAC001_L011')}}"
                                        data-delete-url="{{ route('company.gachas.delete-all') }}"
                                        disabled
                                    >{{ __('labels.CM001_L036') }}</button>
                                    <button class="btn btn-primary ml-auto" id="normal-search">{{ __('labels.CM001_L035') }}</button>
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
                                                    <th class="tb-checkbox">
                                                        <input type="checkbox" class="check-all">
                                                    </th>
                                                    <th class="tb-no mw-50px">
                                                        {{ __('ID') }}
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('typeSort')}}" content-value="id"></i>
                                                    </th>
                                                    <th class="w-150px mw-150px">{{ __('labels.CM001_L003') }}</th>
                                                    <th class="mw-200px">{{ __('labels.GAC001_L004') }}</th>
                                                    <th class="w-100px mw-100px">{{ __('labels.GAC001_L047') }}</th>
                                                    <th class="w-100px mw-100px">
                                                        {{ __('labels.ADM001_L003') }}
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('typeSort')}}" content-value="status"></i>
                                                    </th>
                                                    <th class="tb-action">{{ __('labels.CM001_L011') }}</th>

                                                    <input type="hidden" name="input" value="" id="input"/>
                                                    <input type="hidden" name="typeSort" value="" id="typeSort"/>
                                                    <input type="hidden" name="search" value="{{ Request::get('search') }}"/>
                                                </form>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $item)
                                                    <tr>
                                                        <td class="tb-checkbox">
                                                            <input type="checkbox" class="check-one" value="{{ $item->id }}">
                                                        </td>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            <img src="{{ $item->getThumb() }}" height="100" alt="">
                                                        </td>
                                                        <td><p class="mb-0 line line-2">{{ $item->name }}</p></td>
                                                        <td>{{ __($status_operation[$item->getOperationStatus()] ?? '') }}</td>
                                                        <td>{{ __($status[$item->status] ?? '') }}</td>
                                                        <td class="tb-action">
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('company.gachas.edit', $item->id) }}"
                                                                    class="btn btn-primary mr-0"
                                                                >
                                                                    {{ __('labels.CM001_L009') }}
                                                                </a>
                                                                <a
                                                                    href="javascript: void(0);"
                                                                    data-toggle="modal"
                                                                    class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                    data-target="#modal-delete"
                                                                    data-id="{{ $item->id }}"
                                                                    data-content="{{__('labels.GAC001_L048')}}"
                                                                    data-delete-url="{{ route('company.gachas.destroy', $item->id) }}"
                                                                >
                                                                    {{ __('labels.CM001_L005') }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if (count($datas) == 0)
                                                    <tr role="row" class="odd">
                                                        <th colspan="100%" class="text-center">{{__('messages.H_MSG004')}}</th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7 pagination-wrap">
                                <div class="dataTables_paginate paging_simple_numbers float-left"
                                    id="pagination-content">
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

@include('company.components.modal.delete')

@include('company.components.modal.delete-all')

@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/delete-all.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
@endsection
