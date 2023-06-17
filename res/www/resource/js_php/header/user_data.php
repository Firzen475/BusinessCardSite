<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $token = null;
    if (isset($_GET['token'])) {$token = $_GET['token'];}
    require_once('../jwt/app_client.php');
    $validate = APP_CLIENT::validate($token);
    if ($validate['result']===1){
        $returnArray = array('userId' => $validate['userId']);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;
    }else{
        $returnArray = array('error' => 1);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;
    }


}else{
    $returnArray = array('error' => 'You have requested an invalid method.');
    $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
    echo $jsonEncodedReturnArray;
}