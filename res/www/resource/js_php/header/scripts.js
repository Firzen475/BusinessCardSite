
function logon(info,text){
    $('#user_info').val(info);
    $('#logon').children('.button_text').children('span').text(text);
    $('#logon').click(function() {
        window.location.href = "./logon.php"
    });
}

function user_info(){
    $.ajax({
        type: 'GET',
        url: "./js_php/common/action.php",
        dataType: "json",
        data: {
            token: localStorage.token,
            action: 'validate'
        },
        success: function(data) {
            if (typeof data['userId'] !== 'undefined') {
                $('#user_info').text("Добро пожаловать "+ data['userId']);
                let logon_button = $('#logon');
                logon_button.find('span').text("Выход");
                logon_button.click(function() {
                    console.log("click!");
                    localStorage.clear();
                    logon("Необходимо войти в систему!","Авторизация");
                });
            } else {
                logon("Необходимо войти в систему!","Авторизация");
            }
        }
    });
}

function navigation_active(){

    $('.section_root').children().each(function(){

        if(($(this).offset().top ) < $(window).scrollTop()+$( window ).height()/2){
            var currentClass = $(this).attr('id');
            $('.active').removeClass('active');
            $('a[href="#'+currentClass+'"]').addClass('active');
        }
    })
}

function tmp(){
    $('nav a').on('click',function () {
        let elementClick = $(this).attr("href");
        console.log($(elementClick).offset().top)
        let destination = $(elementClick).offset().top-40;
        $('body').animate( { scrollTop: destination }, 1100 );
        $('html').animate( { scrollTop: destination }, 1100 );
        return false;
    });
}
