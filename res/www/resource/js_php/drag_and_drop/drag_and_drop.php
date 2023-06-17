<?php

class DRAG_AND_DROP{
    public static $target_dir = "/share/";

    public static function upload_files($files){

        foreach( $files as $index => $file )
        {
            $file_size = $file['size'];
            $free = exec("df --output=avail /share/ | tail -n 1");
            if ($file_size < $free){
                $target_file = static::$target_dir . basename($file["name"]);
                move_uploaded_file($file["tmp_name"],$target_file);
            }else{
                return array('error' => 3, "file_size" => $file_size, "free" => $free );
            }
        }
        return array('success' => 1 );
    }

}