@extends('company.layouts.company')
@section('title', __('labels.GAC001_L040', [ 'attr' => $product->reward_type ]))
@section('content')
<div class="content-wrapper">
    <div class="container-fluid pt-3">
        <ul class="breadcrumb">
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
            <li><a href="{{ route('company.gachas.index') }}" title="">{{__('labels.GAC001_L002')}}</a></li>
            <li><a href="{{ route('company.gachas.create') }}" title="">{{__('labels.GAC001_L038')}}</a></li>
            <li><a href="{{ route('company.gachas.show', $gacha->id) }}" title="">{{__('labels.GAC001_L039', [ 'attr' => '１等' ])}}</a></li>
            <li><a href="" title="">{{__('labels.GAC001_L040', [ 'attr' => $product->reward_type ])}}</a></li>
        </ul>

        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('labels.GAC001_L040', [ 'attr' => $product->reward_type ])}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('company.products.update', $product->id) }}" id="product_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="gacha_id" value="{{ $gacha->id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="status" value="{{ PRODUCT_STATUS_ACTIVE }}">

                            @include('company.components.form.text', [
                                'name' => 'reward_type',
                                'value' => old('reward_type', $product->reward_type),
                                'labels' => __('labels.GAC001_L057'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

                            @include('company.components.form.text', [
                                'name' => 'name',
                                'value' => old('name', $product->name),
                                'labels' => __('labels.GAC001_L016'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

                            @include('company.components.form.radio', [
                                'name' => 'reward_status',
                                'value' => old('reward_status', $product->reward_status),
                                'labels' => __('labels.GAC001_L017'),
                                'required' => true,
                                'options' => $rewardStatus,
                            ])

                            @include('company.components.form.percent', [
                                'name' => 'reward_percent',
                                'value' => old('reward_percent', $product->reward_percent),
                                'labels' => __('labels.GAC001_L042'),
                                'placeholder' => 0,
                                'required' => true,
                            ])

                            @include('company.components.form.text', [
                                'type' => 'number',
                                'name' => 'quantity',
                                'value' => old('quantity', $product->quantity),
                                'labels' => __('labels.GAC001_L018'),
                                'placeholder' => __('labels.CM001_L008'),
                                'required' => true,
                            ])

                            @include('admin.components.form.image', [
                                'name' => 'attachment',
                                'value' => $product->getImage(),
                                'labels' => __('labels.BNN001_L008'),
                                'note' => __('labels.BNN001_L010'),
                                'button_text' => __('labels.BNN001_L009'),
                                'required' => true,
                            ])

                            <div class="row">
                                <label class="col-12 col-md-3"></label>
                                <div class="col-12 col-md-8">
                                    <button type="button" data-preview class="btn btn-primary ml-0">{{__('labels.GAC001_L049')}}</button>
                                    <button type="submit" data-status="{{ PRODUCT_STATUS_ACTIVE }}" class="btn btn-primary ml-3">{{__('labels.CM001_L010')}}</button>
                                    <button type="submit" data-status="{{ PRODUCT_STATUS_DRAF }}" class="btn btn-primary ml-3">{{__('labels.GAC001_L050')}}</button>
                                    <a href="{{ route('company.gachas.show', $gacha->id) }}" class="btn btn-primary ml-3">{{__('labels.CM001_L013')}}</a>
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
        const errorMessageMaxLength30 = '{{ __('messages.CM001_L011', ['attr' => 30]) }}';
        const errorMessageRewardPercentRange = '{{ __('messages.GAC001_L004') }}';
        const errorMessagePositive = '{{ __('messages.CM001_L036') }}';

        const errorMessageRequiredImage = '{{ __('messages.CM001_L001') }}';
        const errorMessageFormatImage = '{{ __('messages.BMV001_L001') }}';
        const errorMessageFilesizeImage = '{{ __('messages.CM001_L004', [ 'attr' => '20MB' ]) }}';

        validation('#product_form', {
            'reward_type': {
                required: true,
                maxlength: 30
            },
            'name': {
                required: true,
                maxlength: 30
            },
            'reward_percent': {
                required: true,
                number: true,
                min: 1,
                max: 100
            },
            'quantity': {
                required: true,
                number: true,
                min: 1,
                digits: true,
            },
            'attachment': {
                requiredFile: true,
            }
        }, {
            'reward_type': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength30
            },
            'name': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength30
            },
            'reward_percent': {
                required: errorMessageRequired,
                number: errorMessageRewardPercentRange,
                min: errorMessageRewardPercentRange,
                max: errorMessageRewardPercentRange
            },
            'quantity': {
                required: errorMessageRequired,
                number: errorMessagePositive,
                min: errorMessagePositive,
                digits: errorMessagePositive,
            },
            'attachment': {
                requiredFile: errorMessageRequiredImage,
            }
        });

        imagePreview('#attachment', {
            'required': errorMessageRequiredImage,
            'filesize': errorMessageFilesizeImage,
            'extension': errorMessageFormatImage,
        });

        $('body').on('click', '#product_form button[type=submit]', function (e) {
            e.preventDefault();
            if($('#product_form').valid()) {
                statusValue = $(this).data('status');
                $('#product_form').find('input[name=status]').val(statusValue);
                $('#product_form').submit();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '[data-preview]', function (e) {
                e.preventDefault();
                if ($('#product_form').valid()) {
                    formData = new FormData();

                    serializeData = $('#product_form').serializeArray();
                    $.each(serializeData, function(index, item) {
                        if ($.inArray(item.name, [ '_token', '_method' ]) == -1) {
                            if (item.value.length > 0) {
                                formData.append(item.name, item.value);
                            }
                        }
                    });

                    loadAjaxPost('{{ route('company.products.preview') }}', formData, {
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
