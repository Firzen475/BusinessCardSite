<?php


class WEB_STORAGE{
    public static $target_dir = "/share/";
    private static $key='0344fe8e';
    private static $cipher = "aes-128-gcm";
    public static function df()
    {
        $exec = explode("  ", exec("df -h --output=avail --output=used /share/ | tail -n 1"));
        return array("avail" => $exec[0], "used" => $exec[1]);
    }

    public static function refresh_file_list()
    {
        $output = null;
        $retval = null;
        exec("ls -p /share/ | grep -v /", $output, $retval);
        return $output;
    }

    public static function rename_file($web_storage_old_file_name,$web_storage_new_file_name){
        return array("result" => exec("mv '".static::$target_dir.$web_storage_old_file_name."' '".static::$target_dir.$web_storage_new_file_name."'"), "line" => "mv '".static::$target_dir.$web_storage_old_file_name."' '".static::$target_dir.$web_storage_new_file_name."'");
    }
    public static function delete_file($web_storage_old_file_name){
        return array("result" => exec("rm -rf '".static::$target_dir.$web_storage_old_file_name."'"), "line" => "rm -rf '".static::$target_dir.$web_storage_old_file_name."'");
    }

    public static function download_URL($fileName) {
        $plaintext = $fileName.':'.(time()+600);

        if (in_array(static::$cipher, openssl_get_cipher_methods()))
        {
            $iv = bin2hex(openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-128-gcm")));
            $ciphertext = openssl_encrypt($plaintext, static::$cipher, static::$key, $options=0, $iv,$tag );
            $tmp1 = bin2hex($tag);
            return array("URL" => 'http://'.$_SERVER['SERVER_NAME'].':'.getenv('HTTP_PORT').'/download.php?file='.$iv.":".$ciphertext.":".$tmp1);
        }
    }
}