@extends('admin.layouts.admin')
@section('title', __('labels.GAC001_L002'))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
            <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.GAC001_L002')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.gachas.index') }}" method="GET">
                            <input type="hidden" name="search" value="1">
                            <div class="row mb-4 form-search">
                                <div class="col-sm-6 col-xl-3">
                                    <label>ID</label>
                                    <input class="form-control" name="id" placeholder="ID" value="{{ Request::get('id') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{ __('labels.GAC001_L004') }}</label>
                                    <input class="form-control" name="name" placeholder="{{ __('labels.GAC001_L004') }}" value="{{ Request::get('name') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{ __('labels.GAC001_L005') }}</label>
                                    <input class="form-control" name="company_name" placeholder="{{ __('labels.GAC001_L005') }}" value="{{ Request::get('company_name') }}" />
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <label>{{ __('labels.ADM001_L003') }}</label>
                                    <select class="form-control" name="status">
                                        @foreach ($status as $key => $item)
                                            <option value="{{ $key }}" {{ ($key == Request::get('status')) ? 'selected="selected"' : '' }} >{{ __($item) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <button class="btn btn-primary mr-4" id="normal-search">{{ __('labels.CM001_L035') }}</button>
                                    <button
                                        id="delete-all"
                                        type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-delete-all"
                                        data-content="{{__('labels.GAC001_L011')}}"
                                        data-delete-url="{{ route('admin.gachas.delete-all') }}"
                                        disabled
                                    >{{ __('labels.CM001_L036') }}</button>
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
                                                    <th class="mw-200px">{{ __('labels.GAC001_L005') }}</th>
                                                    <th class="mw-200px">{{ __('labels.GAC001_L004') }}</th>
                                                    <th class="w-70px mw-70px">{{ __('labels.GAC001_L009') }}</th>
                                                    <th class="w-100px mw-100px">
                                                        {{ __('labels.GAC001_L010') }}
                                                        <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('typeSort')}}" content-value="status"></i>
                                                    </th>
                                                    <th class="w-150px mw-150px">{{ __('labels.CM001_L022') }}</th>

                                                    <input type="hidden" name="id" value="{{ Request::get('id') }}"/>
                                                    <input type="hidden" name="name" value="{{ Request::get('name') }}"/>
                                                    <input type="hidden" name="company_name" value="{{ Request::get('company_name') }}"/>
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
                                                        <td class="tb-checkbox">
                                                            <input type="checkbox" class="check-one" value="{{ $item->id }}">
                                                        </td>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            <img src="{{ $item->getThumb() }}" height="100" alt="">
                                                        </td>
                                                        <td><span class="text-overflow-ellipsis row-2">{{ $item->company->company ?? '' }}</span></td>
                                                        <td><a href="{{ route('admin.gachas.show', $item->id) }}" class="text-overflow-ellipsis row-2">{{ $item->name }}</a></td>
                                                        <td class="tb-checkbox text-center">
                                                            <form action="{{ route('admin.gachas.update-recommend', $item->id)  }}" method="post">
                                                                @csrf
                                                                <input type="checkbox" name="recommend" @if($item->recommend == GACHA_RECOMMEND_TRUE) checked @endif>
                                                            </form>
                                                        </td>
                                                        <td>{{ __($status[$item->status] ?? '') }}</td>
                                                        <td>{{ $item->created_at->format('Y年m月d日') }}</td>
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

@include('admin.components.modal.delete-all')

@endsection
@section('javascript')
    <script src="{{ url(mix('js/admin/common/delete-modal.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/delete-all.js')) }}"></script>
    <script src="{{ url(mix('js/admin/common/sort.js')) }}"></script>
    <script>
        $(document).ready(function () {
             $('body').on('change', 'input[name=recommend]', function (e) {
                 e.preventDefault();
                 $(this).closest('form').submit();
             });
        });
    </script>
@endsection
