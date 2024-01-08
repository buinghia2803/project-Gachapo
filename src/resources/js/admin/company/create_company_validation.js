var CreateCompanyValidation = () => {
    return {
        init: function () {
            $('#create_company_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                rules: {
                    'company': {
                        required: true,
                        maxlength : 255
                    },
                    'company_furigana': {
                        required: true,
                        maxlength : 255
                    },
                    'person_manager': {
                        required: true,
                        maxlength : 255
                    },
                    'person_manager_furigana': {
                        required: true,
                        maxlength : 255
                    },
                    'email': {
                        required: true,
                        maxlength : 255,
                        isValidEmail: true
                    },
                    'password': {
                        required: true,
                        minlength : 8,
                        maxlength : 32,
                        isValidPassword: true
                    },
                    'password_confirmation': {
                        required: true,
                        minlength : 8,
                        maxlength : 32,
                        isValidPassword: true,
                        equalTo: '#password',
                    },
                    'commission': {
                        required: true,
                        min: 0,
                        max: 100,
                        isValidComission: true,
                    },
                    'status': {
                        required: true,
                    }
                },
                messages: {
                    company: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter
                    },
                    company_furigana: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter
                    },
                    person_manager: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter
                    },
                    person_manager_furigana: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter
                    },
                    email: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter,
                        isValidEmail: errorMessageEmailValid
                    },
                    password: {
                        required: errorMessageRequired,
                        minlength: errorMessagePasswordInvalid,
                        maxlength: errorMessagePasswordInvalid,
                        isValidPassword: errorMessagePasswordInvalid,
                    },
                    password_confirmation: {
                        required: errorMessageConfirmPasswordNotEqual,
                        minlength: errorMessageConfirmPasswordNotEqual,
                        maxlength: errorMessageConfirmPasswordNotEqual,
                        isValidPassword: errorMessageConfirmPasswordNotEqual,
                        equalTo: errorMessageConfirmPasswordNotEqual,
                    },
                    commission: {
                        required: errorMessageRequired,
                        min: errorMessageInvalidNumber,
                        max: errorMessageInvalidNumber,
                        isValidComission: errorMessageComissionInvalid
                    },
                    status: {
                        required: errorMessageRequired,
                    }
                },
            });

            $.validator.addMethod("isValidPassword", function (value) {
                password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/;
                if(!password.test(value)) {
                    return false;
                }
                return true;
            });

            $.validator.addMethod("isValidEmail", function (value) {
                email = /^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+-\.]{0,60}@[a-zA-Z0-9-\.]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/;
                if(!email.test(value)) {
                    return false;
                }
                return true;
            });

            $.validator.addMethod("isValidComission", function (value) {
                if (value === null || value === '') {
                    return true
                }
                commission = /^\d{1,3}(\.\d{1,2})?$/;
                if(!commission.test(value)) {
                    return false;
                }
                return true;
            });
        },
    }
}

CreateCompanyValidation().init();
