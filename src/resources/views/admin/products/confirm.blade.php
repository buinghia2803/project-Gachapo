@extends('admin.layouts.admin')
@section('title', __('labels.GAC001_L014'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
                <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
                <li><span>{{__('labels.GAC001_L038')}}</span></li>
                <li><span>{{__('labels.GAC001_L039', [ 'attr' => $product->reward_type ])}}</span></li>
                <li><span>{{__('labels.GAC001_L040', [ 'attr' => $product->reward_type ])}}</span></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.GAC001_L041', [ 'attr' => $product->reward_type ])}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L016' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $product->getName() }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L017' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ __(config('options.product_reward_status')[$product->reward_status] ?? '') }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L042' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $product->reward_percent }}%</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L018' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $product->quantity }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L015' )}}</label>
                                <div class="col-12 col-md-8">
                                    <img src="{{ $product->getImage() }}" height="150" alt="">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8">
                                    <a href="{{route('admin.gachas.show', $product->gacha_id)}}" class="btn btn-primary">{{__('labels.CM001_L017')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
