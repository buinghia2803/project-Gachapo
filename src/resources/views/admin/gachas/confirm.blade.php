@extends('admin.layouts.admin')
@section('title', __('labels.GAC001_L014'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
                <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
                <li><span>{{__('labels.GAC001_L014')}}</span></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.GAC001_L014')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L004' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $gacha->getName() }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L023' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $gacha->category->getName() }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L024' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ \CommonHelper::formatPrice($gacha->selling_price ?? 0, '--') }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L025' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ __(config('options.gacha_status_apply_discounts')[$gacha->status_apply_discounts] ?? '--') }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L026' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ \CommonHelper::formatPrice($gacha->discounted_price ?? 0, '--') }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L027' )}}</label>
                                <div class="col-12 col-md-8">
                                    @if(count($gacha->products) == 0)
                                        <p class="confirm_info">{{ '--' }}</p>
                                    @else
                                        @foreach($gacha->products as $products)
                                            <div class="item mb-3 {{ ($loop->index >= GACHA_CONFIRM_PRODUCT_PER_PAGE) ? 'd-none' : '' }}">
                                                <div class="d-flex align-items-center">
                                                    <p class="confirm_info mb-0 mr-3">{{ $products->reward_type  }}</p>
                                                    <a href="{{ route('admin.products.confirm', $products->id) }}" class="btn btn-primary btn-sm w-200px h-40px lh-40px">{{ __('labels.GAC001_L036') }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($gacha->products->count() > GACHA_CONFIRM_PRODUCT_PER_PAGE)
                                        <div class="d-block w-100 text-center">
                                            <a href="javascript:;" class="see-more-product text-bold fz-16px">{{ __('labels.GAC001_L037') }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L028' )}}</label>
                                <div class="col-12 col-md-8">
                                    @if(count($gacha->images) == 0)
                                        <p class="confirm_info">{{ '--' }}</p>
                                    @else
                                        <div class="image-list">
                                            @foreach($gacha->images as $image)
                                                <div class="item">
                                                    <img src="{{ $image->getImage() }}" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L029' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ __(config('options.gacha_status_operation')[$gacha->status_operation] ?? '--') }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L030' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ \CommonHelper::formatTime($gacha->period_start).' - '.\CommonHelper::formatTime($gacha->period_end) }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-12 col-md-3">{{__( 'labels.GAC001_L031' )}}</label>
                                <div class="col-12 col-md-8">
                                    <p class="confirm_info">{{ $gacha->description ?? '--' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8">
                                    <a href="{{route('admin.gachas.show', $gacha->id)}}" class="btn btn-primary">{{__('labels.CM001_L017')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('body').on('click', '.see-more-product', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').find('.item').removeClass('d-none');
            $(this).parent().remove();
        });
    })
</script>
@endsection
