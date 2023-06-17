
function onLoadForm(){
    $('#logon').submit(function () {
        $.ajax({
            type: "POST",
            url: "./js_php/common/action.php",
            dataType: "json",
            data: {
                action: 'logon',
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function(data) {
                if (typeof data['error'] !== 'undefined') {
                    $('#username_label').addClass("bc_error");
                    $('#password_label').addClass("bc_error");
                    localStorage.clear();
                    console.log(data)
                }else {
                    $('#username_label').removeClass("bc_error");
                    $('#password_label').removeClass("bc_error");
                    localStorage.clear();
                    console.log(data)
                    localStorage.token = data['token'];
                    window.location.href = '/';
                }
            },
            error: function(data) {
                console.log(data);
                $('#username_label').addClass("bc_error");
                alert("Error: Login Failed");
            }
        });

        return false;
    });
}



