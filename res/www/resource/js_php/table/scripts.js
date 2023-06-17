
function table_action(button,isEdit){

    $(button).parent().parent().find( "button" ).each(function (index) {
        if ($(this).hasClass("showed")){
            $(this).removeClass("showed");
            $(this).addClass("hidden");
        }else if ($(this).hasClass("hidden")){
            $(this).removeClass("hidden");
            $(this).addClass("showed");
        }

    });
    console.log($(button).parent().parent().parent());
    console.log($(button).parent().parent().parent().children('td').children('.input_button').children('input'));

}
