var UpdateAdminValidation = () => {
    return {
        init: function () {
            $('#update_admin_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                invalidHandler: function (form, validator) {
                    if (!validator.numberOfInvalids())
                        return;

                    var el = $(validator.errorList[0].element);
                    var parentElOffset = el.closest('.form-group').offset().top;
                    var elOffset = el.offset().top;
                    var offset = elOffset + (parentElOffset - elOffset);

                    $('html, body').animate({
                        scrollTop:offset
                    }, 400);
                },
                /*errorPlacement: function(error, element) {
                    if (element.attr("name") === 'gender') {
                        error.insertAfter(".gender-block");
                    } else {
                        error.insertAfter(element);
                    }
                },*/
                rules: {
                    'name': {
                        required: true,
                        maxlength : 255
                    },
                    'email': {
                        required: true,
                        isValidEmail: true,
                    },
                    'password': {
                        maxlength : 16,
                        minlength : 8,
                        isValidPassword: true
                    },
                    'password_confirmation': {
                        equalTo: '#password',
                    },
                    'avatar': {
                        extension: "jpg,jpeg,png",
                        filesize: 5242880, // max size file allowed is 3 MB
                    },
                },
                messages: {
                    name: {
                        required: errorMessageNameRequired,
                        maxlength: errorMessageNameMaxCharacter
                    },
                    email: {
                        required: errorMessageEmailRequired,
                        isValidEmail: errorMessageEmailValid
                    },
                    password: {
                        maxlength: errorMessagePasswordMaxCharacter,
                        minlength: errorMessagePasswordMinCharacter,
                        isValidPassword: errorMessagePasswordInvalid,
                    },
                    password_confirmation: {
                        equalTo: errorMessageConfirmPasswordNotEqual,
                    },
                    avatar: {
                        extension: fileInvalid,
                        filesize: fileMaxSize,
                    },
                },
            });

            $.validator.addMethod("isValidPassword", function (value) {
                if (value === null || value === '') {
                    return true
                }
                password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                if(!password.test(value)) {
                    return false;
                }
                return true;
            });

            $.validator.addMethod("isValidEmail", function (value) {
                email = 　/^[a-zA-Z0-9][a-zA-Z0-9_+-\.]{3,60}@[a-zA-Z0-9-\.]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}$/;
                console.log(value);
                if(!email.test(value)) {
                    console.log(11);
                    return false;
                }
                return true;
            }, errorMessageEmailValid);

            /*$.validator.addMethod("isPhoneNumber", function (value) {
                phone = /^\d{10,11}$/;
                if (value === null || value.length === 0) {
                    return true
                }
                if(!phone.test(value)) {
                    return false;
                }

                return true;
            });*/

            $.validator.addMethod('filesize', function (value, element, arg) {
                if (element.files[0] === null || element.files[0] === '' || element.files[0] === undefined) {
                    return true;
                }
                if(element.files[0].size <= arg){
                    return true;
                }

                return false;
            });
        },
    }
};

UpdateAdminValidation().init();

$(document).ready( function () {
    $('#email').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });
    /*$('#phone_number').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });*/
});
