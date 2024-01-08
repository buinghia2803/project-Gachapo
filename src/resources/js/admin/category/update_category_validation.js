var UpdateCategoryValidation = () => {
    return {
        init: function () {
            $('#update_category_form').validate({
                errorElement: 'div',
                errorClass: 'error-validate',
                focusInvalid: false,
                errorPlacement: function(error, element) {
                    if (element.attr("name") === 'name') {
                        error.insertAfter("#name");
                    } else if (element.attr("name") === 'slug') {
                        error.insertAfter("#slug");
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    'name': {
                        required: true,
                        maxlength : 255
                    },
                    'slug': {
                        required: true,
                        maxlength : 255
                    },
                },
                messages: {
                    name: {
                        required: errorMessageNameRequired,
                        maxlength: errorMessageNameMaxCharacter
                    },
                    slug: {
                        required: errorMessageSlugRequired,
                        maxlength: errorMessageSlugMaxCharacter
                    },
                },
            });
        },
    }
}

UpdateCategoryValidation().init();

$(document).ready( function () {
    $('#name').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });
    $('#slug').keyup(function () {
        $(this).parent().find('.error-valid').remove();
    });
});
