@extends('admin.layouts.admin')
@section('title', __('labels.ADEL001_L007'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/delivery" title="">{{ __('labels.ADEL001_L001') }}</a></li>
                <li><span>{{ __('labels.ADEL001_L007') }}</span></li>
            </ul>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.ADEL001_L007') }}</h3>
                            <a id="download-delivery-btn" href="{{ route('admin.delivery.export-pdf', $data['order_id']) }}">{{ __('labels.CM001_L024') }}</a>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-9">
                              <div class="horizontal-timeline">
                                <ul class="list-inline items d-flex justify-content-between">
                                  <li class="list-inline-item items-list {{ ($data['status_deliver'] >= 1 && $data['status_deliver'] < 4) ? 'active' : '' }}">
                                    <p>{{ __('labels.ADEL001_S001') }}</p>
                                  </li>
                                  <li class="list-inline-item items-list {{ ($data['status_deliver'] >= 2 && $data['status_deliver'] < 4) ? 'active' : '' }}" id="step2">
                                    <p>{{ __('labels.ADEL001_S002') }}</p>
                                  </li>
                                  <li class="list-inline-item items-list text-end {{ ($data['status_deliver'] == 3) ? 'active' : '' }}" id="step3">
                                    <p>{{ __('labels.ADEL001_L011') }}</p>
                                  </li>
                                </ul>
                              </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.ADEL001_L008') }}</h3>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 delivery-information">
                                <p>{{ $data['user']->name }}</p>
                                <p>{{ $data['user']->phone }}</p>
                                <p>{{ $data['user']->address_delivery }}</p>
                            </div>
                        </div>
                        <div class="card-header mt-3">
                            <h3 class="card-title">{{ __('labels.ADEL001_L009') }}</h3>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 delivery-information">
                                @foreach ($delivery as $orderDetail)
                                    <div class="d-flex">
                                        <div><img width="100" src="{{ $orderDetail->product->attachment }}"/></div>
                                        <div class="ml-3">
                                            <div>
                                                <p>{{ $orderDetail->product->name }}</p>
                                            </div>
                                            <div>
                                                <span>{{ __('labels.CM001_L039') }}: </span> {{ $orderDetail->totalProduct }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <p><span>{{ __('labels.ADEL001_L004') }}: </span>{{ \Carbon\Carbon::parse($data['created_at'])->format('Y年m月d日') }}</p>
                                <p><span>{{ __('labels.ADEL001_L005') }}: </span>{{ \Carbon\Carbon::parse($data['date_of_shipment'])->format('Y年m月d日') }}</p>
                            </div>
                            <div class="col-lg-12 d-flex mt-4">
                                <div class="delivery-information">{{ __('labels.ADEL001_L003') }}</div>
                                <form action="{{ route('admin.delivery.update', $data['order_id']) }}" method="POST">
                                    @csrf
                                    @method("PUT")
                                    <div class="row ml-3">
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
                                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex" id="change-delivery-status-btn">
                                            <button class="btn btn-primary">{{ __('labels.CM001_L002') }}</button>
                                            <a href="{{ route('admin.delivery.index') }}"
                                                class="btn btn-secondary ml-3">{{ __('labels.CM001_L013') }}
                                            </a>
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
