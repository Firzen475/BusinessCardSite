<?php

$token = null;
$action = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['token'])) {$token = $_GET['token'];}
    if (isset($_GET['action'])) {$action = $_GET['action'];}
}elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['token'])) {$token = $_POST['token'];}
    if (isset($_POST['action'])) {$action = $_POST['action'];}
}else {
    $returnArray = array('error' => '0');
}
    if(session_id() == ''){ session_start();}
    if ($action==="logon"){
        $username = '';
        $password = '';
        if (isset($_POST['username'])) {$username = $_POST['username'];}
        if (isset($_POST['password'])) {$password = $_POST['password'];}
        require_once('../jwt/app_client.php');
        $jsonEncodedReturnArray = json_encode(APP_CLIENT::login($username,$password), JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;
        exit();
    }
    require_once('../jwt/app_client.php');
    $validate_array=APP_CLIENT::validate($token);
    if ($validate_array['result']===1){

        switch ($action){
            case "validate":
                $returnArray = $validate_array;
                break;
            case "postgres_credentials":
                $tmp = explode("\n", shell_exec("sudo bash /pg_credentials.sh"));
                $pgsql = explode(":", $tmp[0]);
                $pgadmin = explode(":", $tmp[1]);
                $returnArray = array('error' => 0, 'pgsql_user' => $pgsql[0], 'pgsql_pass' => $pgsql[1],
                    'pgadmin_user' => $pgadmin[0], 'pgadmin_pass' => $pgadmin[1]);
                break;
            case "ftp_credentials":
                $tmp = explode("\n", shell_exec("sudo bash /ftp_credentials.sh"));
                $returnArray = array('error' => 0, 'users' => $tmp);
                break;
            case "upload_files":
                require_once('../drag_and_drop/drag_and_drop.php');
                $returnArray = DRAG_AND_DROP::upload_files($_FILES);
                break;
            case "web_storage_df":
                require_once('../section_web_storage/web_storage.php');
                $returnArray = WEB_STORAGE::df();
                break;
            case "web_storage_refresh_file_list":
                require_once('../section_web_storage/web_storage.php');
                $returnArray = WEB_STORAGE::refresh_file_list();
                break;
            case "web_storage_rename_file":
                if (isset($_GET['web_storage_old_file_name']) && isset($_GET['web_storage_new_file_name'])) {
                    $web_storage_old_file_name = $_GET['web_storage_old_file_name'];
                    $web_storage_new_file_name = $_GET['web_storage_new_file_name'];
                    require_once('../section_web_storage/web_storage.php');
                    $returnArray = WEB_STORAGE::rename_file($web_storage_old_file_name,$web_storage_new_file_name);
                }else{
                    $returnArray = array('error' => '2');
                }
                break;
            case "web_storage_delete_file":
                if (isset($_GET['web_storage_old_file_name'])) {
                    $web_storage_old_file_name = $_GET['web_storage_old_file_name'];
                    require_once('../section_web_storage/web_storage.php');
                    $returnArray = WEB_STORAGE::delete_file($web_storage_old_file_name);
                }else{
                    $returnArray = array('error' => '2');
                }
                break;
            case "web_storage_download_URL":
                if (isset($_GET['web_storage_file_name'])) {
                    $web_storage_file_name = $_GET['web_storage_file_name'];
                    require_once('../section_web_storage/web_storage.php');
                    $returnArray = WEB_STORAGE::download_URL($web_storage_file_name);
                }else{
                    $returnArray = array('error' => '2');
                }
                break;
            default:
                $returnArray = array('error' => '2');

        }
    }else{
        $returnArray = array('error' => '1');
    }
$jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
echo $jsonEncodedReturnArray;
exit();