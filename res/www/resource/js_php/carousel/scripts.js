

function onClick_arrow(elem){
    $(elem).parent().parent().children('.slide_holder').each(function (index) {
        var scr = '0';
        if ($(elem).parent().hasClass("l_arrow")){
            scr = '-'+$(this).children('.slide')[0].offsetWidth;
        }else if($(elem).parent().hasClass("r_arrow")){
            scr = $(this).children('.slide')[0].offsetWidth;
        }
        $(this).css("scroll-snap-type", "none");
        $(this).animate({scrollLeft: '+='+scr}, 2000, function() {
            $(this).css("scroll-snap-type", "x mandatory");
            onScroll(this);
        });

    });

}

function onScroll(slide_holder){
    if ($(slide_holder).scrollLeft()===0){
        $(slide_holder).parent().children('.l_arrow').addClass("display_none");
    }else if ($(slide_holder).scrollLeft()+1>=(slide_holder.scrollWidth - slide_holder.clientWidth)){
        $(slide_holder).parent().children('.r_arrow').addClass("display_none");
    }else {
        $(slide_holder).parent().children('.l_arrow').removeClass("display_none");
        $(slide_holder).parent().children('.r_arrow').removeClass("display_none");
    }
}