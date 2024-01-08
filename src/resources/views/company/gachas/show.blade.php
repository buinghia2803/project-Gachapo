@extends('company.layouts.company')
@section('title', __('labels.GAC001_L039', ['attr' => '１等']))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.CDB001_L002')}}</a></li>
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
            <li><a href="{{ route('company.gachas.create') }}" title="">{{__('labels.GAC001_L038')}}</a></li>
            <li><a href="" title="">{{__('labels.GAC001_L039', ['attr' => '１等'])}}</a></li>
        </ul>
        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.GAC001_L039', ['attr' => '１等'])}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 d-flex">
                                @php
                                    $totalPercent = $products->sum('reward_percent');
                                @endphp
                                @if($totalPercent < 100)
                                    <a href="{{ route('company.products.create', [ 'gacha_id' => $gacha->id ]) }}" class="btn btn-primary mr-3">{{ __('labels.CM001_L006') }}</a>
                                @endif
                                <button
                                    id="delete-all"
                                    type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-delete-all"
                                    data-content="{{__('labels.GAC001_L055')}}"
                                    data-delete-url="{{ route('company.products.delete-all') }}"
                                    disabled
                                >{{ __('labels.CM001_L036') }}</button>
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
                                                        <th class="tb-checkbox">
                                                            <input type="checkbox" class="check-all">
                                                        </th>
                                                        <th class="tb-no mw-50px">
                                                            {{ __('ID') }}
                                                            <i class="fas fa-sort mt-1 float-right sort-data" desc="{{Request::get('typeSort')}}" content-value="id"></i>
                                                        </th>
                                                        <th class="w-150px mw-150px">{{ __('labels.GAC001_L015') }}</th>
                                                        <th class="mw-200px">{{ __('labels.GAC001_L016') }}</th>
                                                        <th class="w-70px mw-70px">{{ __('labels.GAC001_L017') }}</th>
                                                        <th class="w-70px mw-70px">{{ __('labels.GAC001_L018') }}</th>
                                                        <th class="tb-action">{{ __('labels.CM001_L011') }}</th>

                                                        <input type="hidden" name="input" value="" id="input"/>
                                                        <input type="hidden" name="typeSort" value="" id="typeSort"/>
                                                        <input type="hidden" name="search" value="{{ Request::get('search') }}"/>
                                                    </form>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $item)
                                                    <tr>
                                                        <td class="tb-checkbox">
                                                            <input type="checkbox" class="check-one" value="{{ $item->id }}">
                                                        </td>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            <img src="{{ $item->getImage() }}" height="100" alt="">
                                                        </td>
                                                        <td><p class="mb-0 line line-2">{{ $item->getName() }}</p></td>
                                                        <td>{{ __($rewardStatus[$item->reward_status] ?? '') }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="tb-action">
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('company.products.edit', $item->id) }}"
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
                                                                    data-content="{{__('labels.GAC001_L056')}}"
                                                                    data-delete-url="{{ route('company.products.destroy', $item->id) }}"
                                                                >
                                                                    {{ __('labels.CM001_L005') }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if (count($products) == 0)
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

                        <div class="row mt-4">
                            <div class="col-12 w-100 text-center">
                                <a href="#" class="btn btn-primary ml-0 w-300px">{{__('labels.GAC001_L049')}}</a>
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
