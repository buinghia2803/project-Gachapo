<div class="gd-info-gacha d-flex flex-row">
    <div class="gd-info-gacha__left">
        <div id="demo" class="carousel slide" data-ride="carousel">
        <!-- The slideshow -->
            <div class="carousel-inner">
                @if(count($images) > 0)
                    @foreach($images as $image)
                        <div class="carousel-item {{ ($loop->index == 0) ? 'active' : '' }}">
                            <img src="{{ $image ?? '' }}" alt="">
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <img src="{{ asset('images/image-default.png') }}" alt="">
                    </div>
                @endif
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

        </div>
    </div>
    <div class="gd-info-gacha__right">
        <div class="gd-info-gacha__title mt-3 mt-md-0">
            <h1 class="m-0">{{ $name ?? '' }}</h1>
        </div>
        <div class="gd-info-gacha__description mt-3">{{ $description ?? '' }}</div>
        <div class="gd-info-gacha__rating box-rating mt-3 d-flex align-items-center">
            <div class="b-rating form-control align-items-center box-rating__icon d-flex readonly w-auto b-none p-0 h-auto">
                <i class="fa fa-star px-1"></i>
                <i class="fa fa-star px-1"></i>
                <i class="fa fa-star px-1"></i>
                <i class="fa fa-star px-1"></i>
                <i class="fa fa-star px-1"></i>
            </div>
            <div class="box-rating__number px-1">(0)</div>
        </div>
        <div class="gd-info-gacha__stock mt-3">{{ __('labels.GAC001_L058', [ 'attr' => $quantity ?? 0 ]) }}</div>
    </div>
</div>

<div class="gd-info-gacha pt-0 d-flex flex-row">
    <div class="gd-info-gacha__right full">
        <div class="gd-info-gacha__price mt-0 d-flex align-items-end">
            <span>{{ __('labels.GAC001_L059', [ 'attr' => $sellingPrice ?? 0 ]) }}</span>
            <input type="number" placeholder="01" class="ml-2 mr-2 form-control">
            <span>回</span>
            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="heart fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-heart-fill gd-info-gacha__like ml-3 ml-md-5 active b-icon bi" data-v-43ed19c6=""><g data-v-43ed19c6=""><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path></g></svg>
        </div>
        <div class="gd-info-gacha__buy mt-4 d-flex flex-wrap">
            <button type="button" class="btn btn btn-red max-w-300 btn-medium btn-secondary">{{__('labels.GAC001_L060')}}</button>
            <div class="gd-info-gacha__message-login hidden-sp">―――　{{__('labels.GAC001_L061')}}</div>
        </div>
    </div>
</div>

@if(count($products) > 0)
    <div class="gd-info-product mt-4">
        <h2 class="title-block text-center mb-0">{{__('labels.GAC001_L012')}}</h2>
        <div class="gacha__list">
            @foreach($products as $item)
                <div class="gacha__box w-100">
                    <div class="gacha__reward-type">{{ $item->reward_type }}</div>
                    <div class="gacha__item bg-white box-shadow">
                        <div class="gacha__quality text-left">{{ __('labels.GAC001_L058', [ 'attr' => $item->quantity ?? 0 ]) }}</div>
                        <div class="gacha__images mt-2">
                            <img src="{{ $item->attachment }}" >
                        </div>
                        <div class="gacha__name text-overflow-ellipsis mt-2 text-left">{{ $item->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
