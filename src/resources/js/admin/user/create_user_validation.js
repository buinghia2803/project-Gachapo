var CreateUserValidation = () => {
    return {
        init: function () {
            $('#create_user_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                rules: {
                    'name': {
                        required: true,
                        maxlength : 100
                    },
                    'name_furigana': {
                        required: true,
                        maxlength : 100
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
                    'status': {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacterForName
                    },
                    name_furigana: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacterForName
                    },
                    email: {
                        required: errorMessageRequired,
                        maxlength: errorMessageMaxCharacter,
                        isValidEmail: errorMessageEmailValid
                    },
                    password: {
                        required: errorMessageRequired,
                        minlength: errorMessagePasswordMinCharacter,
                        maxlength: errorMessagePasswordMaxCharacter,
                        isValidPassword: errorMessagePasswordInvalid,
                    },
                    password_confirmation: {
                        required: errorMessageRequired,
                        minlength: errorMessagePasswordMinCharacter,
                        maxlength: errorMessagePasswordMaxCharacter,
                        isValidPassword: errorMessagePasswordInvalid,
                        equalTo: errorMessageConfirmPasswordNotEqual,
                    },
                    status: {
                        required: errorMessageRequired,
                    },
                },
            });

            $.validator.addMethod("isValidPassword", function (value) {
                if (value === null || value === '') {
                    return true
                }
                password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,32}$/;
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
                if(
                    value.includes(',') ||
                    value.includes('..') ||
                    value.includes('-@') ||
                    value.includes('@-')
                ) {
                    return false;
                }
                return true;
            });
        },
    }
}

CreateUserValidation().init();
