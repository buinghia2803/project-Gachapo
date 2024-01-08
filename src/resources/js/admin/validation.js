$.validator.setDefaults({
    ignore: ".ignore",
    errorClass: 'error-valid',
    focusInvalid: true,
    errorElement: "div",
    errorPlacement: function(error, element) {
        if (element.closest('.image-group').hasClass('image-group')) {
            error.insertAfter( element.closest('.image-group').find('.image-button'));
        } else if (element.closest('.file-group').hasClass('file-group')) {
            error.insertAfter( element.closest('.file-group').find('.file-preview'));
        } else if (element.closest('.textarea-editor').hasClass('textarea-editor')) {
            error.appendTo('.textarea-error');
        } else if (element.closest('.form-check-input').hasClass('form-check-input')) {
            error.appendTo('#type-err');
        } else if (element.closest('.form-percent').hasClass('form-percent')) {
            error.appendTo(element.closest('.form-percent'));
        }
        else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    },
    invalidHandler: function() {},
    submitHandler: function(form) {
        $(form).find('button[type=submit]').prop('disabled', true);
        return true;
    }
});

$.validator.addMethod("isValidAccount", function (value) {
    phone = /^[\s]{0,60}\+?\d{10,13}[\s]{0,60}$/;
    email = /^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+]{3,60}@[a-zA-Z0-9]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/;
    if(!phone.test(value) && !email.test(value)) {
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

$.validator.addMethod("isValidPhone", function (value) {
    phone = /^[\s]{0,60}\+?\d{10,13}[\s]{0,60}$/;
    if(!phone.test(value)) {
        return false;
    }
    return true;
});

$.validator.addMethod("isValidPassword", function (value) {
    password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/;
    if(!password.test(value)) {
        return false;
    }
    return true;
});

$.validator.addMethod("isValidPasswordNotRequire", function (value) {
    if (value.length == 0) {
        return true;
    }
    password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/;
    if(!password.test(value)) {
        return false;
    }
    return true;
});

$.validator.addMethod("requiredFile", function (value, element) {
    let valueAttr = $(element).attr('value');
    if(value.length == 0 && valueAttr.length == 0) {
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

$.validator.addMethod("isValidPasswordForCompany", function (value) {
    if (value === null || value === '') {
        return true
    }
    password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,32}$/;
    if(!password.test(value)) {
        return false;
    }
    return true;
});

function validation(formID, rules, messages) {
    $(formID).validate({
        rules: rules,
        messages: messages,
    });
}
