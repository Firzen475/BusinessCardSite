
function get_ftp_credentials(){
    $.ajax({
        type: 'GET',
        url: "./js_php/common/action.php",
        dataType: "json",
        data: {
            token: localStorage.token,
            action: 'ftp_credentials'
        },
        success: function(data) {
            console.log(data);
            if (data['error'] === 0){
                let ftp_credentials_root = document.createElement("div");

                $.each( data['users'], function( key, value ) {
                    if (value.includes(":")){
                        console.log(value);
                        let tmp = value.split(":");
                        $(ftp_credentials_root).append('<p>Пользователь'+key+' - <span class="bash_text">'+tmp[0]+'</span>; Пароль - <span class="bash_text">'+tmp[1]+'</span></p>');
                    }
                });
                $('#ftp').children().first().append($(ftp_credentials_root));

            }
        }
    });
}