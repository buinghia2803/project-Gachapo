@extends('admin.layouts.admin')
@section('title', __('labels.BMV001_L001'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.banner-main-visuals.index') }}" title="">{{__('labels.BMV001_L001')}}</a></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.BMV001_L001')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @if ($datas->count() < 4)
                                    <a href="{{ route('admin.banner-main-visuals.create') }}" class="btn btn-primary">{{ __('labels.CM001_L006') }}</a>
                                @endif
                            </div>
                        </div>
                        <div id="" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tb-scroll mt-4">
                                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                            <thead>
                                            <tr>
                                                <form action="" method="get" id="form-sort">
                                                    <th class="tb-no">{{ __('ID') }}</th>
                                                    <th class="w-200px">{{ __('labels.CM001_L003') }}</th>
                                                    <th class="mw-200px">{{ __('labels.CM001_L004') }}</th>
                                                    <th class="tb-action">{{ __('labels.CM001_L011') }}</th>
                                                </form>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            <img src="{{ $item->getImage() }}" height="100" alt="">
                                                        </td>
                                                        <td>
                                                            <p class="line line-2">{{ $item->getName() }}</p>
                                                        </td>
                                                        <td class="tb-action">
                                                            <div class="d-flex align-items-center">
                                                                <a 
                                                                    href="{{ route('admin.banner-main-visuals.edit', $item->id) }}" 
                                                                    class="btn btn-primary" 
                                                                    style="margin-right: 0 !important;"
                                                                >
                                                                    {{ __('labels.CM001_L009') }}
                                                                </a>
                                                                <a 
                                                                    href="javascript: void(0);"
                                                                    data-toggle="modal"
                                                                    class="btn btn-danger btn-grey no-width btn-release text-white btn-remove-large"
                                                                    data-target="#modal-delete"
                                                                    data-id="{{ $item->id }}"
                                                                    data-content="{{__('labels.CM001_L018',['title' => $item->getName()])}}"
                                                                    data-delete-url="{{ route('admin.banner-main-visuals.destroy', $item->id) }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.components.modal.delete')

@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
@endsection