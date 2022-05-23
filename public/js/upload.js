$(document).ready(function () {
    $('.datepicker').datepicker({
        language: 'sv',
        weekStart: 1,
        todayHighlight: true
    });
    /* Toggle video permissions settings */
    $(document).on('change', '#permission', function () {
        var bool = $("#video_perm").is(":hidden")
        $("#video_perm").toggleClass('hidden')
        $("#video_perm").attr('hidden', !bool)
    });
});
