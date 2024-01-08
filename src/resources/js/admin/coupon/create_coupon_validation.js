var CreateCouponValidation = () => {
    return {
        init: function () {
            $('#create_coupon_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                errorPlacement: function(error, element) {
                    if (element.attr("name") === 'discount_amount' || element.attr("name") === 'discount_rate') {
                        error.appendTo('#discount-type-error');
                    } else if (element.attr("name") === 'period_start') {
                        error.appendTo('#period-start-error');
                    } else if (element.attr("name") === 'period_end') {
                        error.appendTo('#period-end-error');
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    'name': {
                        required: true,
                        maxlength : 255
                    },
                    'type_discount': {
                        required: true,
                    },
                    'discount_rate': {
                        discountRateRequired: true,
                        min: 0,
                        max: 100,
                        isValidDiscountRate: true,
                    },
                    'discount_amount': {
                        discountAmountRequired: true,
                        min: 0,
                    },
                    'code': {
                        required: true,
                        maxlength: 8,
                        isValidCode: true,
                    },
                    'description': {
                        required: true,
                        maxlength : 2000
                    },
                    'period_start': {
                        periodStartRequired: true,
                    },
                    'period_end': {
                        periodEndRequired: true,
                    }
                },
                messages: {
                    name: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter
                    },
                    type_discount: {
                        required: errorMessageRequired,
                    },
                    discount_rate: {
                        discountRateRequired: errorMessageRequired,
                        min: errorMessageInvalidNumber,
                        max: errorMessageInvalidNumber,
                        isValidDiscountRate: errorMessgeWrongFormat,
                    },
                    discount_amount: {
                        discountAmountRequired: errorMessageRequired,
                        min: errorMessageInvalidNumber,
                    },
                    code: {
                        required: errorMessageRequired,
                        maxlength: errorMessageCodeLength,
                        isValidCode: errorMessgeCode,
                    },
                    description: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxDescription,
                    },
                    period_start: {
                        periodStartRequired: errorMessageRequired,
                    },
                    period_end: {
                        periodEndRequired: errorMessageRequired,
                    }
                },
            });

            $.validator.addMethod("discountRateRequired", function (value) {
                if (value) return true;
                if ($("input[type='radio'][name=type_discount]:checked").val() == 1) {
                    return false;
                }

                return true;
            });

            $.validator.addMethod("isValidDiscountRate", function (value) {
                if (value === null || value === '') {
                    return true
                }
                discountRate = /^\d{1,3}(\.\d{1,2})?$/;
                if(!discountRate.test(value)) {
                    return false;
                }
                return true;
            });

            $.validator.addMethod("discountAmountRequired", function (value) {
                if (value) return true;
                if ($("input[type='radio'][name=type_discount]:checked").val() == 2) {
                    return false;
                }

                return true;
            });

            $.validator.addMethod("isValidCode", function (value) {
                if (value === null || value === '') {
                    return true
                }
                code = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8}$/;
                if(!code.test(value)) {
                    return false;
                }
                return true;
            });

            $.validator.addMethod("periodStartRequired", function (value) {
                if (value) return true;
                if (!$("input[name=period_end]").val()) {
                    return false;
                }

                return true;
            });

            $.validator.addMethod("periodEndRequired", function (value) {
                if (value) return true;
                if (!$("input[name=period_start]").val()) {
                    return false;
                }

                return true;
            });
        },
    }
}

CreateCouponValidation().init();
