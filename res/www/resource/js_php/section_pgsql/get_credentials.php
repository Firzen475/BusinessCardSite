<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $token = null;
    if (isset($_GET['token'])) {$token = $_GET['token'];}
    require_once('../jwt/app_client.php');
    $validate = APP_CLIENT::validate($token);
    if ($validate['result']===1){
        $tmp = explode("\n", shell_exec("sudo bash /credentials.sh"));
        $pgsql = explode(":", $tmp[0]);
        $pgadmin = explode(":", $tmp[1]);
        $returnArray = array('error' => 0, 'pgsql_user' => $pgsql[0], 'pgsql_pass' => $pgsql[1],
            'pgadmin_user' => $pgadmin[0], 'pgadmin_pass' => $pgadmin[1]);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;
    }else{
        $returnArray = array('error' => 1);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;
    }


}else{
    $returnArray = array('error' => 1);
    $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
    echo $jsonEncodedReturnArray;
}