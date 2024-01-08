@extends('company.layouts.company')
@section('title', __('labels.ADEL001_L007'))
<style>
    .table th,
    .table td {
        border-top: none !important
    }

</style>
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title=""> {{ __('labels.CM001_L066') }}</a></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <h3 class="card-title">{{ __('labels.ADEL001_L007') }}</h3>

                            <a id="download-delivery-btn"
                                href="{{ route('company.delivery.export-pdf', $data['order_id']) }}">{{ __('labels.CM001_L024') }}</a>

                        </div>
                        <div class="card-header mt-4">
                            {{-- infomation user --}}
                            <h3 class="card-title">{{ __('labels.ADEL001_L008') }}</h3>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 delivery-information">
                                <table class="table">
                                    <tbody>

                                        <tr>
                                            <td>{{ __('labels.ADM001_L009') }}</td>
                                            <td>{{ $data['user']->name != '' ? $data['user']->name : 'No user' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('labels.CM001_L025') }}</td>
                                            <td>{{ $data['user']->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('labels.CM001_L021') }}</td>
                                            <td>{{ $data['user']->address_delivery }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-header mt-3">
                            {{-- infomation product --}}
                            <h3 class="card-title">{{ __('labels.ADEL001_L009') }}</h3>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 delivery-information">
                                {{-- image product --}}
                                @foreach ($delivery as $orderDetail)
                                    <div class="d-flex">
                                        <div><img width="50" src="{{ $orderDetail->product->attachment }}" />
                                        </div>
                                        <div class="ml-3">
                                            <p>{{ $orderDetail->product->name }}</p>
                                        </div>
                                        <div>
                                            <span>{{ __('labels.CM001_L039') }}: </span>
                                            {{ $orderDetail->totalProduct }}
                                        </div>
                                    </div>
                                @endforeach
                                <p><span>{{ __('labels.ADEL001_L004') }}:
                                    </span>{{ \Carbon\Carbon::parse($data['created_at'])->format('Y年m月d日') }}</p>


                            </div>
                            <div class="col-lg-12 d-flex mt-4">
                                {{-- <div class="delivery-information">{{ __('labels.ADEL001_L003') }}</div> --}}
                                <form action="{{ route('company.delivery.update', $data['order_id']) }}" id="update_delivery_company" method="POST">
                                    @csrf
                                    @method("PUT")
                                    <input type="text" name="date_of_shipment" class="form-control mb-3" value="{{ \Carbon\Carbon::parse($data['date_of_shipment'])->format('Y/m/d') }}">
                                    @error('date_of_shipment')
                                    <div class="error-valid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-2 col-xl-2">
                                            <select class="form-control" name="status_deliver" style="min-width: 215px">
                                                @foreach ($statusList as $key => $item)
                                                    <option value="{{ $key }}"
                                                        {{ $data['status_deliver'] == $key ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 d-flex"
                                            id="change-delivery-status-btn">
                                            <button class="btn btn-primary col-6">{{ __('labels.CM001_L010') }}</button>
                                            <a href="{{route('company.delivery.index')}}" class="btn btn-primary" style="border: none;"> {{ __('labels.CM001_L017') }}</a>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';

        validation('#update_delivery_company', {
            'date_of_shipment': {
                required: true,
            },
        }, {
            'date_of_shipment': {
                required: errorMessageRequired,
            },
        });
    </script>
@endsection
