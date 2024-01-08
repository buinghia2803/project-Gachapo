var UpdateUserValidation = () => {
    return {
        init: function () {
            $('#update_user_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                errorPlacement: function(error, element) {
                    if (element.attr("name") === 'gender') {
                        error.insertAfter(".gender-block");
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    'name': {
                        required: true,
                        maxlength : 100
                    },
                    'email': {
                        required: true,
                        email: true,
                    },
                    'password': {
                        maxlength : 8,
                        minlength : 32,
                        isValidPassword: true
                    },
                    'password_confirmation': {
                        equalTo: '#password',
                    },
                },
                messages: {
                    name: {
                        required: errorMessageNameRequired,
                        maxlength: errorMessageNameMaxCharacter
                    },
                    email: {
                        required: errorMessageEmailRequired,
                        email: errorMessageEmailValid
                    },
                    password: {
                        maxlength: errorMessagePasswordMaxCharacter,
                        minlength: errorMessagePasswordMinCharacter
                    },
                    password_confirmation: {
                        equalTo: errorMessageConfirmPasswordNotEqual,
                    },
                },
            });

            $.validator.addMethod("isValidPassword", function (value) {
                if (value === null || value === '') {
                    return true
                }
                return true;
            }, errorMessagePassword);
        },
    }
}

UpdateUserValidation().init();

$(document).ready( function () {
    $('#email').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });
    $('#phone_number').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });
});

$(document).on('submit', '#update_user_form', function () {
    sessionStorage.setItem('phone_number', $('#phone_number').val());
});
if ($('#phone-error').length) {
    $('#phone_number').val(sessionStorage.getItem('phone_number'))
} else {
    sessionStorage.removeItem("phone_number");
}
