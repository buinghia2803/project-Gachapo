@extends('admin.layouts.admin')
@section('title', __('labels.ACPL001_L012'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
                <ul class="breadcrumb">
                    <li><a href="/admin/coupon" title="">{{ __('labels.ACPL001_L003') }}</a></li>
                    <li><span>{{ __('labels.ACPL001_L012') }}</span></li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('labels.ACPL001_L012') }}</h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('admin.coupon.update', $coupon->id) }}" id="create_coupon_form" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="name" class="col-12 col-md-4">{{ __('labels.ACPL001_L004') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="name" class="form-control"
                                                        id="name" placeholder="{{ __('labels.ACPL001_L004') }}" value="{{ old('name', $coupon->name) }}">
                                                    @error('name')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.ACPL001_L005') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <div class="d-flex align-items-center justify-content-between type_discount_wrap">
                                                        <div class="rating d-flex justify-content-between align-items-center w-150px">
                                                            <input class="form-check-input"
                                                                value="{{ COUPON_TYPE_PERCENT }}"
                                                                type="radio"
                                                                name="type_discount"
                                                                id="rate"
                                                                checked
                                                                {{ COUPON_TYPE_PERCENT == old('type_discount', $coupon->type_discount) ? 'checked':'' }}>
                                                            <input type="text"
                                                                id="discount_rate"
                                                                value="{{ old('discount_rate', $coupon->discount_rate) }}"
                                                                name="discount_rate"
                                                                class="type_discount">
                                                            <span class="type_discount_unit">%</span>
                                                        </div>

                                                        <div class="amouting d-flex justify-content-between align-items-center w-200px ml-5">
                                                            <input class="form-check-input"
                                                                value="{{ COUPON_TYPE_PRICE }}"
                                                                type="radio"
                                                                name="type_discount"
                                                                id="amount"
                                                                {{ COUPON_TYPE_PRICE == old('type_discount', $coupon->type_discount) ? 'checked':'' }}>
                                                            <input type="text"
                                                                id="discount_amount"
                                                                value="{{ old('discount_amount', $coupon->discount_amount) }}"
                                                                name ="discount_amount"
                                                                class="type_discount">
                                                            <span class="type_discount_unit">{{ __('labels.ACPL001_L006') }}</span>
                                                        </div>
                                                    </div>
                                                    <div id="discount-type-error" class="mt-2"></div>
                                                    @error('type_discount')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    @error('discount_rate')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    @error('discount_amount')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="code" class="col-12 col-md-4">{{ __('labels.ACPL001_L007') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <input type="text" name="code" class="form-control"
                                                        id="code" placeholder="{{ __('labels.ACPL001_L007') }}"
                                                        value="{{ old('code', $coupon->code) }}">
                                                    @error('code')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <p class="mt-3 ml-3" style="color: grey; font-size: 16px;">{{ __('labels.ACPL001_L008') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label for="description" class="col-12 col-md-4">{{ __('labels.ACPL001_L009') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <textarea name="description"
                                                        class="form-control w-100 mw-100 h-auto p-2"
                                                        rows="5">{{ old('description', $coupon->description) }}</textarea>
                                                    @error('description')
                                                        <div class="error-valid">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-3 m-0">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-12 col-xl-9">
                                            <div class="row d-flex align-items-baseline">
                                                <label class="col-12 col-md-4">{{ __('labels.ACPL001_L002') }}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        <input class="form-control" name="period_start" autocomplete="off" id="period_start" value="{{ old('period_start', \Carbon\Carbon::parse($coupon->period_start)->format('Y-m-d H:i')) }}" />
                                                        <span class="ml-2 mr-2 fz-16px">~</span>
                                                        <input class="form-control" name="period_end" autocomplete="off" id="period_end" value="{{ old('period_end', \Carbon\Carbon::parse($coupon->period_end)->format('Y-m-d H:i')) }}" />
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <div id="period-start-error" class="form-control custom-control">
                                                            @error('period_start')
                                                                <div class="error-valid">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <span class="ml-2 mr-2 fz-16px"></span>
                                                        <div id="period-end-error" class="form-control custom-control">
                                                            @error('period_end')
                                                                <div class="error-valid">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
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
                                                <label class="col-12 col-md-4"></label>
                                                <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                    <button type="submit"
                                                            class="btn btn-primary">{{ __('labels.CM001_L002') }}</button>
                                                    <a href="{{route('admin.coupon.index')}}"
                                                        class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L013') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <style>
        div.error-validate {
            font-size: 14px;
            color: red;
        }
        div.error-valid {
            font-size: 14px;
            color: red;
        }
    </style>
@endsection
@section('javascript')
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L011', ["attr" => "255"]) }}';
        const errorMessageMaxDescription = '{{ __('messages.CM001_L011', ["attr" => "2000"]) }}';
        const errorMessageInvalidNumber = '{{ __('messages.CO001_MSG002') }}';
        const errorMessgeWrongFormat = '{{ __('messages.CO001_MSG001') }}';
        const errorMessageCodeLength = '{{ __('messages.CM001_L011', ["attr" => "8"]) }}';
        const errorMessgeCode = '{{ __('messages.CM001_L033') }}';
        const errorStartTime = '{{ __('messages.ANM001_MSG001') }}';
        const errorEndTime = '{{ __('messages.ANM001_MSG002') }}';
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#discount_rate").on("keyup", function (e) {
                if (!$.isNumeric(e.target.value)) {
                    $(this).val("");
                }
            });

            $("#discount_amount").on("keyup", function (e) {
                if (!$.isNumeric(e.target.value)) {
                    $(this).val("");
                }
            });

            if ($('input[type=radio][name=type_discount]:checked').val() == 1) {
                $('input[name=discount_amount]').prop('disabled', true);
                $('input[name=discount_amount]').val("");
            } else {
                $('input[name=discount_rate]').prop('disabled', true);
                $('input[name=discount_rate]').val("");
            }

            $('input[type=radio][name=type_discount]').change(function() {
                if (this.value == 1) {
                    $('input[name=discount_rate]').prop('disabled', false);
                    $('input[name=discount_amount]').prop('disabled', true);
                    $('input[name=discount_amount]').val("");
                } else if (this.value == 2) {
                    $('input[name=discount_amount]').prop('disabled', false);
                    $('input[name=discount_rate]').prop('disabled', true);
                    $('input[name=discount_rate]').val("");
                }
            });

            var checkPastTime = function(inputDateTime) {
                if (typeof(inputDateTime) != "undefined" && inputDateTime !== null) {
                    const endTime = $('#period_end').datetimepicker('getValue');
                    $('#period-start-error').text('');
                    if ($('#period_end').val() && $('#period_end').val() && inputDateTime >= endTime) {
                        $('#period_start').datetimepicker('reset');
                        $('#period-start-error').text(errorStartTime);
                        $('#period_start').datetimepicker('hide');
                    }
                }
            };

            var checkPastTimeForEndtime = function(inputDateTime) {
                if (typeof(inputDateTime) != "undefined" && inputDateTime !== null) {
                    const startTime = $('#period_start').datetimepicker('getValue');
                    $('#period-end-error').text('');
                    if ($('#period_start').val() && $('#period_end').val() && startTime >= inputDateTime) {
                        $('#period_end').datetimepicker('reset');
                        $('#period-end-error').text(errorEndTime);
                        $('#period_end').datetimepicker('hide');
                    }
                }
            };

            $('#period_start').datetimepicker(
                {
                    format: 'Y-m-d H:i',
                    language: 'ja',
                    onChangeDateTime:checkPastTime,
                    onShow:checkPastTime,
                }
            );

            $('#period_end').datetimepicker(
                {
                    format: 'Y-m-d H:i',
                    language: 'ja',
                    onChangeDateTime:checkPastTimeForEndtime,
                    onShow:checkPastTimeForEndtime,
                }
            );
        });
    </script>
    <script src="{{ url(mix('js/admin/coupon/create_coupon_validation.js')) }}"></script>
@endsection
