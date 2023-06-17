<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['file'])) {
        $key='0344fe8e';
        $cipher='aes-128-gcm';

        $file = $_GET['file'];
        $tmp0 = explode(":", $file);

        $original_plaintext = openssl_decrypt($tmp0[1], $cipher, $key, $options=0,  $tmp0[0],hex2bin($tmp0[2]));
        $tmp1 = explode(":", $original_plaintext);
        if (time()<$tmp1[1]){
            $filename = "/share/".$tmp1[0];
            if (file_exists($filename)) {
                header ("Content-Type: application/octet-stream");
                header ('Content-Description: File Transfer');
                header ("Accept-Ranges: bytes");
                header ('Content-Transfer-Encoding: binary');
                header ("Content-Length: ".filesize($filename));
                header ("Content-Disposition: attachment; filename=".basename($filename));
                //Передаем наш файл в ответ на запрос
                readfile($filename);
            }else{
                var_dump("----Файла нет на сервере 0_0-----");
            }

        }

    }

}

