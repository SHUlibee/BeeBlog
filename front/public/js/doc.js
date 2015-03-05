
$(function()
{
    $('#main').css('min-height', $(window).height());
    // popover demo
    $("[data-toggle=popover]").popover();

    var currouter = $("#currouter").val();
    if(currouter){
        $("#"+currouter+"").addClass("active");
        $("#"+currouter+"").parent('.collapsed').removeClass("collapsed");
    }

    // navbar collapse
    $('.navbar-collapsed .nav > .nav-heading').click(function(event)
    {
        var $nav = $(this).closest('.nav');
        if($nav.hasClass('collapsed'))
        {
            if($(window).width() < 767)
            {
                $('.navbar-collapsed .nav').not($nav).children('li:not(.nav-heading)').slideUp('fast', function(){
                    $(this).closest('.nav').addClass('collapsed');
                });
            }
            $nav.removeClass('collapsed').children('li:not(.nav-heading)').slideDown('fast');
        }
        else
        {
            $nav.children('li:not(.nav-heading)').slideUp('fast', function(){$nav.addClass('collapsed')});
        }
    });
    
     // datetime picker
    if($.fn.datetimepicker)
    {
        $('.form-datetime').datetimepicker(
        {
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1,
            format: 'yyyy-mm-dd hh:ii'
        });
        $('.form-date').datetimepicker(
        {
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            format: 'yyyy-mm-dd'
        });
        $('.form-time').datetimepicker({
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
            format: 'hh:ii'
        });
    }


});
