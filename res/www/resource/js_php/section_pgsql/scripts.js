
function get_pg_credentials(){
    $.ajax({
        type: 'GET',
        url: "./js_php/common/action.php",
        dataType: "json",
        data: {
            token: localStorage.token,
            action: 'postgres_credentials'
        },
        success: function(data) {
            console.log(data);
            if (data['error'] === 0){
                $('#database').children().first().append('<div><p>PostgreSQL: Пользователь - <span class="bash_text">'+data['pgsql_user']+
                    '</span>; Пароль - <span class="bash_text">'+data['pgsql_pass']+'</span></p>' +
                    '<p>PGAdmin: Пользователь - <span class="bash_text">'+data['pgadmin_user']+
                    '</span>; Пароль - <span class="bash_text">'+data['pgadmin_pass']+'</span></p></div>')
            }
        }
    });
}