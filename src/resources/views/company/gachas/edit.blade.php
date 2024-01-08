@extends('company.layouts.company')
@section('title', __('labels.GAC001_L052'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.CDB001_L002')}}</a></li>
                <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
                <li><a href="{{ route('company.gachas.edit', $gacha->id) }}" title="">{{__('labels.GAC001_L052')}}</a></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('labels.GAC001_L052')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('company.gachas.update', $gacha->id) }}" id="gacha_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input type="hidden" name="gacha_id" value="{{ $gacha->id }}">

                                @include('company.components.form.text', [
                                    'name' => 'name',
                                    'value' => $gacha->name,
                                    'labels' => __('labels.GAC001_L004'),
                                    'placeholder' => __('messages.CM001_L011', [ 'attr' => 20 ]),
                                    'required' => true,
                                ])

                                @include('company.components.form.select', [
                                    'name' => 'category_id',
                                    'value' => $gacha->category_id,
                                    'labels' => __('labels.GAC001_L023'),
                                    'required' => true,
                                    'options' => $categories,
                                ])

                                @include('company.components.form.text', [
                                    'type' => 'number',
                                    'name' => 'selling_price',
                                    'value' => $gacha->selling_price,
                                    'labels' => __('labels.GAC001_L024'),
                                    'placeholder' => __('labels.CM001_L008'),
                                    'required' => true,
                                ])

                                @include('company.components.form.radio', [
                                    'name' => 'status_apply_discounts',
                                    'value' => $gacha->status_apply_discounts,
                                    'labels' => __('labels.GAC001_L025'),
                                    'required' => true,
                                    'options' => $status_apply_discounts,
                                ])

                                @include('company.components.form.text', [
                                    'type' => 'number',
                                    'name' => 'discounted_price',
                                    'value' => $gacha->discounted_price,
                                    'labels' => __('labels.GAC001_L026'),
                                    'placeholder' => __('labels.CM001_L008'),
                                    'required' => true,
                                ])

                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="" class="col-12 col-md-4">{{__('labels.GAC001_L027')}}</label>
                                            <div class="col-12 col-md-8">
                                                @if(count($gacha->products) == 0)
                                                    <p class="confirm_info">{{ '--' }}</p>
                                                @else
                                                    @foreach($gacha->products as $product)
                                                        <div class="item mb-3 {{ ($loop->index >= GACHA_CONFIRM_PRODUCT_PER_PAGE) ? 'd-none' : '' }}">
                                                            <div class="d-flex align-items-center">
                                                                <p class="confirm_info mb-0 mr-3">{{ $product->reward_type  }}</p>
                                                                <a href="{{ route('company.products.edit', $product->id) }}" target="_blank" class="btn btn-primary btn-sm w-200px h-40px lh-40px">{{ __('labels.GAC001_L036') }}</a>
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

                                            <label for="" class="col-12 col-md-4"></label>
                                            <div class="col-12 col-md-8 mt-3">
                                                <div class="file-group">
                                                    <input name="product_xlsx" id="product_xlsx" type="file" accept=".xlsx" hidden/>
                                                    <div class="file-button mb-2">
                                                        <label class="btn btn-secondary btn-sm text-white m-0 w-200px h-40px lh-40px" for="product_xlsx">{{__('labels.GAC001_L054')}}</label>
                                                    </div>
                                                    <div class="file-preview d-none">
                                                        <div class="d-flex align-items-center">
                                                            <strong class="fz-16px mb-0 mr-2"></strong>
                                                            <div class="file-group-remove fz-16px"><i class="fa fa-times"></i></div>
                                                        </div>
                                                    </div>
                                                    @error('product_xlsx') <div class="error-valid">{{ $message }}</div> @enderror
                                                    <div class="mt-3">
                                                        <a href="{{ route('company.gachas.show', $gacha->id) }}" class="btn btn-secondary btn-sm text-white m-0 w-200px h-40px lh-40px" target="_blank">{{__('labels.GAC001_L053')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="name" class="col-12 col-md-4">{{__('labels.GAC001_L028')}}</label>
                                            <div class="col-12 col-md-8">

                                                <div class="image-group">
                                                    @php
                                                        $images = $gacha->images;
                                                        $image1 = ($images->first()) ? $images->first()->getImage() : null;
                                                        $image2 = ($images->skip(1)->first()) ? $images->skip(1)->first()->getImage() : null;
                                                        $image3 = ($images->skip(2)->first()) ? $images->skip(2)->first()->getImage() : null;
                                                    @endphp
                                                    <input name="images[]" id="images" type="file"  accept="image/*" hidden multiple/>
                                                    <input name="change_images" id="change_images" type="hidden" value="{{ SET_NOT_AVATAR }}"/>
                                                    <div class="d-flex image-group-content">
                                                        <div class="image-preview mr-3 i-1">
                                                            <input name="images_base64[]" type="hidden" class="image-preview-base64" value="{{ $image1 ?? '' }}"/>
                                                            <img src="{{ $image1 ?? asset('images/image-default.png') }}" class="image-group-img" alt=""/>
                                                            <div class="image-group-remove"><i class="fa fa-times"></i></div>
                                                        </div>
                                                        <div class="image-preview mr-3 i-2">
                                                            <input name="images_base64[]" type="hidden" class="image-preview-base64" value="{{ $image2 ?? '' }}"/>
                                                            <img src="{{ $image2 ?? asset('images/image-default.png') }}" class="image-group-img" alt=""/>
                                                            <div class="image-group-remove"><i class="fa fa-times"></i></div>
                                                        </div>
                                                        <div class="image-preview mr-3 i-3">
                                                            <input name="images_base64[]" type="hidden" class="image-preview-base64" value="{{ $image3 ?? '' }}"/>
                                                            <img src="{{ $image3 ?? asset('images/image-default.png') }}" class="image-group-img" alt=""/>
                                                            <div class="image-group-remove"><i class="fa fa-times"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="image-button">
                                                        <p class="mb-0">{!! 'ガチャイメージ画像' !!}</p>
                                                        <label class="btn btn-primary text-white" for="images">{{__('ファイル選択')}}</label>
                                                    </div>
                                                    @error('images') <div class="error-valid">{{ $message }}</div> @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>

                                @include('company.components.form.radio', [
                                    'name' => 'status_operation',
                                    'value' => $gacha->status_operation,
                                    'labels' => __('labels.GAC001_L029'),
                                    'required' => true,
                                    'options' => $status_operation,
                                ])

                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label for="period_start" class="col-12 col-md-4">{{__('labels.GAC001_L030')}}<span class="required">*</span></label>
                                            <div class="col-12 col-md-8 datetimepicker">
                                                <div class="d-flex">
                                                    <div class="d-block w-100">
                                                        <input class="form-control bg-white" name="period_start" autocomplete="off" id="period_start" value="{{ old('period_start', \CommonHelper::formatTime($gacha->period_start, 'Y-m-d')) }}" placeholder="{{ __('labels.CM001_L040') }}" readonly/>
                                                        @error('period_start') <div class="error-valid">{{ $message }}</div> @enderror
                                                    </div>
                                                    <span class="mt-3 ml-2 mr-2 fz-16px">~</span>
                                                    <div class="d-block w-100">
                                                        <input class="form-control bg-white" name="period_end" autocomplete="off" id="period_end" value="{{ old('period_end', \CommonHelper::formatTime($gacha->period_end, 'Y-m-d')) }}" placeholder="{{ __('labels.CM001_L040') }}" readonly/>
                                                        @error('period_end') <div class="error-valid">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>

                                @include('company.components.form.textarea', [
                                    'name' => 'description',
                                    'value' => $gacha->description,
                                    'labels' => __('labels.GAC001_L031'),
                                    'placeholder' => __('messages.CM001_L011', [ 'attr' => 500 ]),
                                    'required' => true,
                                ])

                                <div class="row">
                                    <label class="col-12 col-md-3"></label>
                                    <div class="col-12 col-md-8">
                                        <button type="button" data-preview class="btn btn-primary ml-0">{{__('labels.GAC001_L049')}}</button>
                                        <button type="submit" name="status" value="{{ GACHA_DRAF }}" class="btn btn-primary ml-3">{{__('labels.GAC001_L050')}}</button>
                                        <button type="submit" class="btn btn-primary ml-3">{{__('labels.GAC001_L051')}}</button>
                                        <a href="{{ route('company.gachas.index') }}" class="btn btn-primary ml-3">{{__('labels.CM001_L013')}}</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="content preview-gacha page__content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <link rel="stylesheet" href="{{ asset('css/preview-gacha.css') }}">
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageNameMaxLength = '{{ __('messages.CM001_L011', ['attr' => 20]) }}';
        const errorMessageSellingPriceMin = '{{ __('messages.CM001_L032', ['attr' => 0]) }}';
        const errorMessageDescriptionMax = '{{ __('messages.CM001_L025', ['attr' => 500]) }}';

        const errorMessageRequiredImage = '{{ __('messages.CM001_L001') }}';
        const errorMessageFormatImage = '{{ __('messages.BMV001_L001') }}';
        const errorMessageFilesizeImage = '{{ __('messages.CM001_L004', [ 'attr' => '20MB' ]) }}';

        const errorMessageFormatFile = '{{ __('messages.CM001_L034', ['attr' => 'xlsx']) }}';

        const errorImage = {
            'required': errorMessageRequiredImage,
            'filesize': errorMessageFilesizeImage,
            'extension': errorMessageFormatImage,
        }

        validation('#gacha_form', {
            'name': {
                required: true,
                maxlength: 20
            },
            'selling_price': {
                required: true,
                min: 0
            },
            'discounted_price': {
                required: true,
            },
            'description': {
                required: true,
                maxlength: 500
            },
            'period_start': {
                required: true
            },
            'period_end': {
                required: true
            },
            'product_xlsx': {
                accept: false,
                extension: 'xlsx'
            }
        }, {
            'name': {
                required: errorMessageRequired,
                maxlength: errorMessageNameMaxLength
            },
            'selling_price': {
                required: errorMessageRequired,
                min: errorMessageSellingPriceMin
            },
            'discounted_price': {
                required: errorMessageRequired
            },
            'description': {
                required: errorMessageRequired,
                maxlength: errorMessageDescriptionMax
            },
            'period_start': {
                required: errorMessageRequired
            },
            'period_end': {
                required: errorMessageRequired
            },
            'product_xlsx': {
                extension: errorMessageFormatFile
            }
        });

        filePreview('#product_xlsx', {
            'filesize': errorMessageFilesizeImage,
            'extension': errorMessageFormatFile
        }, [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);

        $('body').on('click', '.see-more-product', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').find('.item').removeClass('d-none');
            $(this).parent().remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            next7Day = moment().add(7, 'days').format('YYYY-MM-DD');

            $.datetimepicker.setLocale('ja');
            $('#period_start').datetimepicker({
                timepicker:false,
                format: 'Y-m-d',
                scrollMonth : false,
                scrollInput : false,
                minDate: next7Day,
                onSelectDate:function(dp,input){
                    startTime = input.val();

                    if(startTime.length > 0) {
                        next2Month = moment(startTime).add(2, 'month').format('YYYY-MM-DD');
                        $('#period_end').val('');
                        $('#period_end').datetimepicker({
                            timepicker:false,
                            format: 'Y-m-d',
                            scrollMonth : false,
                            scrollInput : false,
                            minDate: startTime,
                            maxDate: next2Month,
                        });
                    }
                }
            });
            $('#period_end').datetimepicker({
                timepicker:false,
                format: 'Y-m-d',
                scrollMonth : false,
                scrollInput : false,
                minDate: next7Day,
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            imageDefault = '{{ asset('/images/image-default.png') }}';

            $('body').on('click', '.image-group-remove', function (e) {
                e.preventDefault();
                parent = $(this).closest('.image-preview');
                if (parent.find('.image-preview-base64').val().length > 0) {
                    $('#change_images').val('{{ SET_AS_AVATAR }}');
                }
                parent.find('.image-preview-base64').val('');
                parent.find('.image-group-img').attr('src', imageDefault);
            });

            $('body').on('change', '#images', function (e) {
                e.preventDefault();
                el = $(this);
                imageGroup = el.closest('.image-group');
                files = this.files;
                imageGroup.find('.error-valid').remove();
                if (files.length > 0) {
                    errorFileSize = false;
                    errorExtension = false;
                    imageGroup.find('.image-group-remove').click();

                    $.each(files, function (index, file) {
                        if (index < 3) {
                            if (file.size >= 20971520) {
                                errorFileSize = true;
                            } else if(!inArray(file.type, ['image/png','image/jpeg'])) {
                                errorExtension = true;
                            } else {
                                let reader = new FileReader();
                                reader.onload = function(event) {
                                    imagePreview = URL.createObjectURL(file);
                                    imageContent = imageGroup.find('.image-group-content').find('.image-preview')[index];
                                    $(imageContent).find('.image-group-img').attr('src', imagePreview);
                                    $(imageContent).find('.image-preview-base64').val(event.target.result);
                                };
                                reader.readAsDataURL(file);
                            }
                        }
                    });
                    if (errorFileSize == true) {
                        imageGroup.find('.image-group-remove').click();
                        imageGroup.find('.image-button').after('<div class="error-valid">'+errorImage.filesize+'</div>');
                    }
                    if (errorExtension == true) {
                        imageGroup.find('.image-group-remove').click();
                        imageGroup.find('.image-button').after('<div class="error-valid">'+errorImage.extension+'</div>');
                    }
                }
            });

            // Auto gen base64 for image
            image1 = $($('input[name^=images_base64]')[0]);
            dataImage1 = image1.val();
            if(dataImage1.length > 0) {
                convertUrlToBase64(dataImage1, function(base64) {
                    image1.val(base64).attr('value', base64);
                });
            }

            image2 = $($('input[name^=images_base64]')[1]);
            dataImage2 = image2.val();
            if(dataImage2.length > 0) {
                convertUrlToBase64(dataImage2, function(base64) {
                    image2.val(base64).attr('value', base64);
                });
            }

            image3 = $($('input[name^=images_base64]')[2]);
            dataImage3 = image3.val();
            if(dataImage3.length > 0) {
                convertUrlToBase64(dataImage3, function(base64) {
                    image3.val(base64).attr('value', base64);
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '[data-preview]', function (e) {
                e.preventDefault();
                if ($('#gacha_form').valid()) {
                    formData = new FormData();

                    serializeData = $('#gacha_form').serializeArray();
                    $.each(serializeData, function(index, item) {
                        if ($.inArray(item.name, [ '_token', '_method' ]) == -1) {
                            if (item.value.length > 0) {
                                formData.append(item.name, item.value);
                            }
                        }
                    });
                    console.log(serializeData);

                    product_xlsx = $('input[name=product_xlsx]').prop('files');
                    if (product_xlsx[0] != undefined) {
                        formData.append('product_xlsx', product_xlsx[0]);
                    }

                    loadAjaxPost('{{ route('company.gachas.preview') }}', formData, {
                        beforeSend: function(){},
                        success:function(result){
                            $('#modal-preview').find('.preview-gacha').html(result.html);
                            $('#modal-preview').modal('show');
                            setTimeout(function () {
                                $('#demo').carousel();
                            }, 200);
                        },
                        error: function (error) {}
                    }, 'loading');
                }
            });
        });
    </script>
@endsection
