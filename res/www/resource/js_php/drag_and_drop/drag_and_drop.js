var isUpload = false;
let dropArea = document.getElementById('drop-area');
console.log("dropArea => " + dropArea);
['dragenter', 'dragover', 'dragleave', 'drop', 'mouseover', 'mouseout' ].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false)
})
function preventDefaults (e) {
    e.preventDefault()
    e.stopPropagation()
}

;['dragenter', 'dragover', 'mouseover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false)
})
;['dragleave', 'drop', 'mouseout'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false)
})
function highlight(e) {
    if(!isUpload){
        dropArea.classList.add('highlight')
    }

}
function unhighlight(e) {
    dropArea.classList.remove('highlight')
}

dropArea.addEventListener('drop', handleDrop, false)

function handleDrop(e) {
    console.log("handleDrop")
    if(!isUpload){
        let dt = e.dataTransfer
        let files = dt.files
        console.log(files)
        uploadFile(files);
    }

}

function handleFiles(files) {
    uploadFile(files);
}

function uploadFile(files) {
    var formData = new FormData();
    formData.append('token', localStorage.token);
    formData.append('action', 'upload_files');
    jQuery.each(files, function(i, file) {
        formData.append('file-'+i, file);
    });
    $.ajax({
        type: 'POST',
        url: "./js_php/common/action.php",
        dataType: "json",
        processData: false,
        contentType: false,
        data:formData,
        xhr: function() {
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function(e) {
                isUpload = true;
                var percent = Math.floor(e.loaded / e.total *100 );
                $("#progress_bar_label").text(percent + '%');
                var slider = $("#progress_bar");
                console.log(slider.parent().width());
                var add_width = (percent/100*slider.parent().width())+'px';
                console.log(add_width);
                slider.stop(true, true).animate({width: add_width }, 500 );
                //console.log(Math.floor(e.loaded / e.total *100) + '%');
            };
            return xhr;
        },
        success: function(data) {
            console.log(data);
            /*clearInterval(timerId);*/
            if (data['error']===0){
                popupEvent("Не верный тип запроса!");
            }
            if (data['error']===1){
                popupEvent("Для загрузки файлов нужно войти в систему!");
            }
            if (data['error']===2){
                popupEvent("Не указано действие для API!");
            }
            if (data['error']===3){
                popupEvent("Недостаточно места на сервере! Нужно: "+data['file_size']+", свободно "+data['free']);
            }
            isUpload = false;
            df();
            refresh_file_list();

        }
    });

}



