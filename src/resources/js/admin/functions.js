// load ajax
/*
    loadAjaxPost(url, params, {
        beforeSend: function(){},
        success:function(result){},
        error: function (error) {}
    }, 'loading');
*/
function loadAjaxPost(url, params, option, type = 'loading'){
    var _option = {
        beforeSend:function(){},
        success:function(result){},
        error:function(error){}
    }
    $.extend(_option,option);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        enctype: 'multipart/form-data',
        url: url,
        data: params,
        processData: false,
        contentType: false,
        beforeSend: function(){
            switch (type) {
                case 'loading': loadingBox('open'); break;
            }
            _option.beforeSend();
        },
        success:function(result){
            switch (type) {
                case 'loading': loadingBox('close'); break;
            }
            _option.success(result);
        },
        error: function (error) {
            switch (type) {
                case 'loading': loadingBox('close'); break;
            }
            _option.error(error);
        }
    })
}
/*
    loadAjaxGet(url, {
        beforeSend: function(){},
        success:function(result){},
        error: function (error) {}
    }, 'progress');
*/
function loadAjaxGet(url, option, type = 'loading'){
    var _option = {
        beforeSend:function(){},
        success:function(result){},
        error:function(error){}
    }
    $.extend(_option,option);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: url,
        beforeSend: function(){
            switch (type) {
                case 'loading': loadingBox('open'); break;
            }
            _option.beforeSend();
        },
        success:function(result){
            switch (type) {
                case 'loading': loadingBox('close'); break;
            }
            _option.success(result);
        },
        error: function (error) {
            switch (type) {
                case 'loading': loadingBox('close'); break;
            }
            _option.error(error);
        }
    })
}

// LoadingBox
function loadingBox(type = 'open') {
    if (type == 'open') {
        $('body').append(`<div class="loading-box"><div class="loading-box__image"></div></div>`);
        $(".loading-box").css({visibility:"visible", opacity: 0.0}).animate({opacity: 1.0},200);
    } else {
        $(".loading-box").animate({opacity: 0.0}, 200, function(){
            $(this).remove();
        });
    }
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function imagePreview(id, validation = {}, acceptExt = ['image/png','image/jpeg']) {
    inputFile = $(id);
    imageBox = inputFile.closest('.image-group');
    imageDefault = '/images/image-default.png';

    $('body').on('click', '.image-group-remove', function (e) {
        e.preventDefault();
        $(this).closest('.image-group').find('.image-group-img').attr('src', imageDefault);
        $(this).closest('.image-group').find('input[type=file]').val('').attr('value', '');
        $(this).closest('.image-group').find('.image-preview-input').val('');
        $(this).closest('.image-group').find('.image-preview-base64').val('');
    });

    $('body').on('change', id, function(e) {
        e.preventDefault();
        el = $(this);
        file = this.files[0];
        $(imageBox).find('.error-valid').remove();
        if (file) {
            if (file.size >= 20971520) {
                el.closest('.image-group').find('.image-group-remove').click();
                $(imageBox).find('.image-button').after('<div class="error-valid">'+validation.filesize+'</div>');
            } else {
                if (inArray(file.type, acceptExt)) {
                    imagePreview = URL.createObjectURL(file);
                    $(imageBox).find('.image-group-img').attr('src', imagePreview);

                    let reader = new FileReader();
                    reader.onload = function(event) {
                        let img = new Image();
                        img.onload = function() {
                            el.closest('.image-group').find('.image-preview-base64').val(img.src);
                        }
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    el.closest('.image-group').find('.image-group-remove').click();
                    $(imageBox).find('.image-button').after('<div class="error-valid">'+validation.extension+'</div>');
                }
            }
        }
    });
}

function filePreview(id, validation = {}, acceptExt = []) {
    inputFile = $(id);
    fileBox = inputFile.closest('.file-group');

    $('body').on('click', '.file-group-remove', function (e) {
        e.preventDefault();
        $(this).closest('.file-group').find('input[type=file]').val('').attr('value', '');
        $(this).closest('.file-group').find('.file-preview').find('strong').html('');
        $(this).closest('.file-group').find('.file-preview').addClass('d-none');
    });

    $('body').on('change', id, function(e) {
        e.preventDefault();
        el = $(this);
        file = this.files[0];
        $(fileBox).find('.error-valid').remove();
        if (file) {
            if (file.size >= 20971520) {
                el.closest('.file-group').find('.image-group-remove').click();
                $(fileBox).find('.file-preview').after('<div class="error-valid">'+validation.filesize+'</div>');
            } else {
                if (inArray(file.type, acceptExt)) {
                    $(this).closest('.file-group').find('.file-preview').removeClass('d-none');
                    $(this).closest('.file-group').find('.file-preview').find('strong').html(file.name);
                } else {
                    el.closest('.file-group').find('.image-group-remove').click();
                    $(fileBox).find('.file-preview').after('<div class="error-valid">'+validation.extension+'</div>');
                }
            }
        }
    });

}

function convertUrlToBase64(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}
