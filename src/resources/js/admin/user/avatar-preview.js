(function ($) {
    $.extend({
        imagePreview: function (options) {

            let settings = $.extend({
                preview: ".image-preview",
                inputSource: ".image-preview-input",
                outputSource: ".image-preview-output",
                callback: null
            }, options);

            let input = document.getElementById('imag');

            // Check if FileReader is available
            if (window.File && window.FileList && window.FileReader) {
                if (typeof ($(settings.preview).attr('src')) === null || $(settings.preview).attr('src') === '') {
                    $('#ImgPreview').unbind('error').hide();
                }
                if (typeof ($(settings.outputSource).attr('value')) !== 'undefined' && $(settings.outputSource).attr('value') !== null && $(settings.outputSource).attr('value') !== '') {
                    delAvatar();
                }
                if (typeof ($(settings.inputSource)) !== 'undefined' && $(settings.inputSource) !== null && $(settings.inputSource).length > 0) {
                    $(settings.inputSource).change(function () {
                        //handleFile(this.files);
                        if ($('.append-error')) {
                            $('.append-error').hide();
                        }
                        if (fileExtensionValidation() === false) {
                            $('<div class="error-validate append-error" style="margin-bottom: 20px;">' + fileInvalid + '</div>').insertAfter('.box-img-upload');
                        } else if (fileSizeValidation() === false) {
                            $('<div class="error-validate append-error" style="margin-bottom: 20px;">' + fileMaxSize + '</div>').insertAfter('.box-img-upload');
                        } else {
                            resizeImageToSpecificWidth(600, function(dat) {
                                $(settings.preview).attr('src', dat);
                                $(settings.outputSource).val(dat);
                                delAvatar();
                            });
                        }
                    });
                }
            }

            /*function handleFile(files) {
                files = [...files];
                // Append to preview top image
                let reader = new FileReader();
                reader.readAsDataURL(files[0]);
                reader.onloadend = function () {
                    $(settings.preview).attr('src', reader.result);
                    $(settings.outputSource).attr('value', reader.result);
                    delAvatar();
                }

                if (settings.callback) {
                    settings.callback();
                }
            }*/

            function resizeImageToSpecificWidth(max, cb) {
                let data;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        let img = new Image();
                        img.onload = function() {
                            if (img.width > max) {
                                let oc = document.createElement('canvas'), octx = oc.getContext('2d');
                                oc.width = img.width;
                                oc.height = img.height;
                                octx.drawImage(img, 0, 0);
                                if( img.width > img.height) {
                                    oc.height = (img.height / img.width) * max;
                                    oc.width = max;
                                } else {
                                    oc.width = (img.width / img.height) * max;
                                    oc.height = max;
                                }
                                octx.drawImage(oc, 0, 0, oc.width, oc.height);
                                octx.drawImage(img, 0, 0, oc.width, oc.height);
                                data = oc.toDataURL();
                            } else {
                                data = img.src;
                            }
                            cb(data);
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function fileExtensionValidation(){
                const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; //image extensions allow

                //Check image extensions and max size
                if(!allowedExtensions.exec(input.value)) {
                    input.value = '';
                    return false;
                }

                return true;
            }

            function fileSizeValidation(){
                const fileLimit = 5120; // could be whatever you want

                if (input.files && input.files[0]) {
                    let fileSize = input.files[0].size;

                    const fileSizeInKB = (fileSize/1024); // image size to KB

                    if (fileSizeInKB > fileLimit) {
                        input.value = '';
                        return false;
                    }
                }

                return true;
            }
        }
    });
})(jQuery);

$(document).ready(function () {
    $.imagePreview();
});

var delAvatar = () => {
    $('<i class="fa fa-times del" id="removeImage"></i>').insertAfter('#ImgPreview')
    if ($('#ImgPreview').attr('style', 'display:none')) {
        $('#ImgPreview').removeAttr('style');
    }

    $('#removeImage').on('click',function () {
        $('#imag').val("");
        $('#avatar').attr("value", '');
        $('#ImgPreview').attr("src", "");
        $('#ImgPreview').unbind('error').hide();
        $('.preview').removeClass('it');
        $('.btn-rmv').removeClass('rmv');
        $('i').remove('#removeImage');
    })

    $('.del').on('click',function () {
        $('#imag').val("");
        $('#avatar').attr("value", '');
        $('.preview').removeClass('it');
        $('.btn-rmv').removeClass('rmv');
        $('i').remove('#removeImage');
        $('#del-flg').val('on');
        $('#ImgPreview').attr("src", urlAvatarDefault);
        //$('#ImgPreview').unbind('error').hide();

    })

}
