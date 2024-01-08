@extends('admin.layouts.admin')
@section('title', __('labels.ADM001_L001'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.admin_users.index') }}" title="">{{__('labels.ADM001_L001')}}</a></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.ADM001_L001')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.admin_users.index') }}" method="GET">
                            <input type="hidden" name="search" value="1">
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
                                    <label>{{ __('labels.ADM001_L003') }}</label>
                                    <select class="form-control" name="status">
                                        <option value="">{{ __('labels.CM001_L012') }}</option>
                                        @foreach ($status as $key => $item)
                                            <option value="{{ $key }}" {{ ($key == Request::get('status')) ? 'selected="selected"' : '' }} >{{ __($item) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-xl-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                    <a href="{{ route('admin.admin_users.create') }}" class="btn btn-primary">{{ __('labels.CM001_L006') }}</a>
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
                                                    <th class="tb-no">
                                                        {{ __('ID') }}
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('typeSort')}}" content-value="id"></i>
                                                    </th>
                                                    <th class="mw-200px">{{ __('labels.ADM001_L002') }}</th>
                                                    <th class="mw-200px">{{ __('labels.ADM001_L007') }}</th>
                                                    <th class="w-100px mw-100px">{{ __('labels.ADM001_L003') }}</th>
                                                    <th class="w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>
                                                    <th class="tb-action">{{ __('labels.CM001_L011') }}</th>

                                                    <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                    <input type="hidden" name="name" value="{{ Request::get('name') }}"/>
                                                    <input type="hidden" name="status" value="{{ Request::get('status') }}"/>
                                                    <input type="hidden" name="input" value="" id="input"/>
                                                    <input type="hidden" name="typeSort" value="" id="typeSort"/>
                                                    <input type="hidden" name="search" value="{{ Request::get('search') }}"/>
                                                </form>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->getName() }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->getStatusText() }}</td>
                                                        <td>{{ $item->created_at->format('Y年m月d日') }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('admin.admin_users.edit', $item->id) }}"
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
                                                                    data-delete-url="{{ route('admin.admin_users.destroy', $item->id) }}"
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
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                {{ $datas->appends(request()->all())->links() }}
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
