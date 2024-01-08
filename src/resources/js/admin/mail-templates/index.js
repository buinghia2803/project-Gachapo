$(document).ready(function() {
    const templatesTypeInfo = JSON.parse($('#templates-type-info').val());
    templatesTypeInfo?.forEach(typeInfo => {
        CKEDITOR.replace(`editor-${typeInfo.type}`, {
            language: 'ja',
        });

        let file = $(`.template-${typeInfo.type}-file`).data('value').split('/')[1];

        if (file) {
            $(`.template-${typeInfo.type}-file`).siblings(".custom-file-label").addClass("selected")
                .html(file);
        }

        $(`.template-${typeInfo.type}-file`).on("change", function() {
            const fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
    $('.tab').on('click', function () {
        const type = $(this).data('type');
        window.history.replaceState('', '', `?type=${type}`);
    })

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, function(size){
        return "MAX SIZE " + filesize(size,{exponent:2,round:1});
    });

    for (let j = 1; j <= list_mailtemplate.length; j++) {
        $(`#mail-template-${j}`).validate({
            errorElement: 'div',
            errorClass: 'error-validate d-inline-block',
            focusInvalid: false,
            errorPlacement: function(error, element) {
                if (element.data("input") === "editor") {
                    error.insertAfter(`p#error-content-${j}`);
                    return;
                } else if (element.attr("name") === 'attachment') {
                    error.appendTo(`#attach-mail-template-${j}`);
                } else if (element.attr("name") === 'subject') {
                    error.appendTo(`#error-subject-${j}`);
                } else if (element.attr("name") === 'cc[]') {
                    error.appendTo(`#error-cc-${j}`);
                } else if (element.attr("name") === 'bcc[]') {
                    error.appendTo(`#error-bcc-${j}`);
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            rules: {
                subject: {
                    required: true,
                    maxlength : 255
                },
                'cc[]': {
                    isValidMailC: true
                },
                'bcc[]': {
                    isValidMailC: true
                },
                content: {
                    required: function(textarea) {
                        $(`#${textarea.id}`).attr('style', 'display: none !important')
                        CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                        var editorcontent = textarea.value.replace(
                            /<[^>]*>/gi,
                            ""
                        ); // strip tags

                        return editorcontent.length === 0;
                    }
                },
                attachment: {
                    filesize: 20971520, // 20MB - 20971520 byte
                }
            },
            messages: {
                subject: {
                    required: errorInputRequired,
                    maxlength: errorMaxlength255
                },
                'cc[]': {
                    isValidMailC: errorMessageEmailValid
                },
                'bcc[]': {
                    isValidMailC: errorMessageEmailValid
                },
                content: {
                    required: errorInputRequired,
                },
                attachment: {
                    filesize: attachmentFileMaxSize, // <= 20MB
                }
            },
        });

        $.validator.addMethod("isValidMailC", function(value){
            email = /^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+-\.]{0,60}@[a-zA-Z0-9-\.]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/;
                    let countErr = 0;
                    for (let i = 0; i < value.length; i++) {
                        const element = value[i];
                        if(!email.test(element)) {
                            countErr++;
                            break;
                        }
                        if(
                            element.includes(',') ||
                            element.includes('..') ||
                            element.includes('-@') ||
                            element.includes('@-')
                        ) {
                            countErr++;
                            break;
                        }
                    }
                    if (countErr > 0) {
                        return false;
                    }
            if (
                value.includes(',') ||
                value.includes('..') ||
                value.includes('-@') ||
                value.includes('@-')
            ) {
                return false;
            }
            return true;
        });

        $.validator.addMethod("isNoHasSpace", function(value){
            let val = value.replace(/  +/g, '');
            val = val.replace(' ','');
            if(val.length != 0) {
                return true;
            }
            return false;
        }, errorInputRequired);

        $(`#resetFile-${j}`).on('click', function() {
            $(`.attachment-${j}`).val('');
            $(`#custom-file-label-${j}`).text(defaultTextAttachment);
            $(`#old_attachment-${j}`).val('');
            $(`#attach-mail-template-${j}`).text('');
        });
    }
});
