$(document).ready(function () {
    var checkPastTime = function(inputDateTime) {
        if (typeof(inputDateTime) != "undefined" && inputDateTime !== null) {
            var current = new Date(new Date().toLocaleString("ja",{timeZone:'Asia/Tokyo'}));
            var endTime = $('#end_time').datetimepicker('getValue');
            $('#start-time-error').text('');
            if ($('#end_time').val() && inputDateTime >= endTime) {
                $('#start_time').datetimepicker('reset');
                $('#start-time-error').text(errorStartTime);
            }
        }
    };

    var checkPastTimeForEndtime = function(inputDateTime) {
        if (typeof(inputDateTime) != "undefined" && inputDateTime !== null) {
            var startTime = $('#start_time').datetimepicker('getValue');
            $('#end-time-error').text('');
            if ($('#start_time').val() && $('#end_time').val() && startTime >= inputDateTime) {
                $('#end_time').datetimepicker('reset');
                $('#end-time-error').text(errorEndTime);
            }
        }
    };

    $('#start_time').datetimepicker({
        format: 'Y-m-d H:i:s',
        minDate : 0,
        step: 1,
        onChangeDateTime:checkPastTime,
        onShow:checkPastTime,
    });
    $('#end_time').datetimepicker({
        format: 'Y-m-d H:i:s',
        step: 1,
        onChangeDateTime:checkPastTimeForEndtime,
        onShow:checkPastTimeForEndtime,
    });
    $.datetimepicker.setLocale('ja');
});
