
function key_filter(e,el){
    console.log($(el).val())
    console.log(e.key);
    let regexp = "^[\\w._]{1,30}[\\w]$";
    if (!($(el).val()).match(regexp)){
        console.log("1");
        $(el).parent().addClass('input_error') ;
        $(el).parent().removeClass('input_simple');
    }else {
        console.log("2");
        $(el).parent().addClass('input_simple') ;
        $(el).parent().removeClass('input_error');
    }
}

function df(){
    $.ajax({
        type: 'GET',
        url: "./js_php/common/action.php",
        dataType: "json",
        data: {
            token: localStorage.token,
            action: 'web_storage_df'
        },
        success: function(data) {
            console.log(data)
            $("#avail").text(data["avail"]);
            $("#used").text(data["used"]);
        }
    });
}

function refresh_file_list(){

    $.ajax({
        type: 'GET',
        url: "./js_php/common/action.php",
        dataType: "json",
        data: {
            token: localStorage.token,
            action: 'web_storage_refresh_file_list'
        },
        success: function(data) {
            var file_table = $("#file_table");
            file_table.empty();
            let str =
                "<tr class=\"sticky_table_header bg_color\">\n" +
                "   <th class=\"column_num f_0\">№</th>\n" +
                "   <th class=\"f_1\">Имя</th>\n" +
                "</tr>"
            file_table.append($.parseHTML( str ))
            data.forEach((element,index) => {
                let str =
                    "<tr>\n" +
                    "   <td class=\"column_num f_0\">"+(1+index)+"</td>\n" +
                    "   <td class=\"f_1\">\n" +
                    "       <div class=\"input_button input_simple f_1\" onclick='download_URL(this)'>\n" +
                    "           <input class=\"f_1\" type=\"text\" disabled value=\""+element+"\" onkeyup='key_filter(event,this)' >\n" +
                    "           <label style='display: none' ></label>\n" +
                    "           <div class=\"t1\"></div>\n" +
                    "       </div>\n" +
                    "   </td>\n" +
                    "   <td class=\"action_confirm flex_row f_0\">\n" +
                    "       <div class=\"flex_column f_1\">\n" +
                    "            <button class=\"icon_button material-icons normal moved_highlight showed\" onclick='web_storage_action(this,true)'>edit</button>\n" +
                    "            <button class=\"icon_button material-icons accept moved_highlight hidden\" onclick='web_storage_action_apply(this)'>check</button>\n" +
                    "       </div>\n" +
                    "       <div class=\"flex_column f_1\">\n" +
                    "            <button class=\"icon_button material-icons warn moved_highlight showed\" onclick='web_storage_action(this,false)'>delete</button>\n" +
                    "            <button class=\"icon_button material-icons warn moved_highlight hidden\" onclick='web_storage_action(this)'>cancel</button>\n" +
                    "       </div>\n" +
                    "   </td>\n" +
                    "</tr>";
                file_table.append( $.parseHTML( str ) );
            })
        }
    });
}

function web_storage_action(elem){
    switch ($(elem).text()){
        case "edit":
            $(elem).parent().parent().parent().children('td').children('.input_button').children('input').each(function (index) {
                $(this).prop('disabled', false);
                $(this).next().text($(this).val())
            });
            break;
        default :
            $(elem).parent().parent().parent().children('td').children('.input_button').children('input').each(function (index) {
                $(this).prop('disabled', true);
            });
            break;
    }
    table_action(elem);
}

function web_storage_action_apply(elem){
    $(elem).parent().parent().parent().children('td').children('.input_button').children('input').each(function (index) {
        if (this.disabled){
            $.ajax({
                type: 'GET',
                url: "./js_php/common/action.php",
                dataType: "json",
                data: {
                    token: localStorage.token,
                    action: 'web_storage_delete_file',
                    web_storage_old_file_name: $(this).val()
                },
                success: function(data) {
                    console.log(data);
                    web_storage_action(elem);
                    refresh_file_list();
                }
            });
        }else {
            let regexp = "^[\\w._]{1,30}[\\w]$";
            console.log($(this).val());
            console.log($(this).val().match(regexp));
            if (!$(this).val().match(regexp)) {
                popupEvent("Ошибка в названии файла! Название не должно содержать пробелы и спец. символы!");
                return;
            }
            $.ajax({
                type: 'GET',
                url: "./js_php/common/action.php",
                dataType: "json",
                data: {
                    token: localStorage.token,
                    action: 'web_storage_rename_file',
                    web_storage_old_file_name: $(this).next().text(),
                    web_storage_new_file_name: $(this).val()
                },
                success: function(data) {
                    console.log(data);
                    web_storage_action(elem);
                    refresh_file_list();
                }
            });
        }
    });


}

function download_URL(elem){
    let input = $(elem).children("input");

    if (!input.disabled){
        console.log($(input).val());
        $.ajax({
            type: 'GET',
            url: "./js_php/common/action.php",
            dataType: "json",
            data: {
                token: localStorage.token,
                action: 'web_storage_download_URL',
                web_storage_file_name: $(input).val()
            },
            success: function(data) {
                console.log(data);
                navigator.clipboard.writeText(data["URL"])
                    .then(() => {
                        popupEvent("Ссылка скопирована в буфер обмена и будет доступна 10 минут!");
                    })
                    .catch(err => {
                        popupEvent("Ошибка при копировании в буфер обмена: "+err );

                    });

            }
        });
    }

}