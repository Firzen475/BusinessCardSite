<?php

class APP_CLIENT{
    public static $connection_string = "host=pgsql port=5432 dbname=postgres user=postgres password=Pa\$\$word!";
    public static $select_string = "SELECT extract(epoch from re_login),enabled FROM app_user WHERE ";
    public static $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
    public static function login($username,$password){
        $conn = pg_connect(static::$connection_string);
        if (!$conn) {
            return array('error' => 'Ошибка соединения с базой!');
        }
        $result = pg_query($conn, static::$select_string . "username = '$username' AND password = '$password' LIMIT 1;");
        if (!$result) {
            return array('error' => 'Ошибка запроса!');
        }
        while ($row = pg_fetch_row($result)) {
            require_once('jwt.php');
            if ($row[1]!=='1'){
                return array('error' => 'Ползователь отключен!');
            }
            /**
             * Uncomment the following line and add an appropriate date to enable the
             * "not before" feature.
             */
            // $nbf = strtotime('2021-01-01 00:00:01');
            /**
             * Uncomment the following line and add an appropriate date and time to enable the
             * "expire" feature.
             */
            $exp = microtime(true)+(60*60*24*7);
            pg_exec($conn, "update app_user set re_login = to_timestamp($exp) where username = '$username' and password = '$password';");

            // create a token
            $payloadArray = array();
            $payloadArray['userId'] = $username;
            if (isset($nbf)) {$payloadArray['nbf'] = $nbf;}
            if (isset($exp)) {$payloadArray['exp'] = $exp;}
            $token = JWT::encode($payloadArray, static::$serverKey);

            // return to caller
            return array('token' => $token);
        }
        return array('error' => 'Invalid user ID or password.');
    }

    public static function validate($token){
        if (is_null($token)) {
            return array('result' => 0);
        }
        require_once('jwt.php');
        try {
            $payload = JWT::decode($token, static::$serverKey, array('HS256'));
            $returnArray = array('username' => $payload->userId);
            if (isset($payload->exp)) {
                $returnArray['exp'] = date(DateTime::ISO8601, $payload->exp);;
            }
            $conn = pg_connect(static::$connection_string);


            if (!$conn) {
                return array('result' => 0);
            }
            $username = $returnArray['username'];
            $result = pg_query($conn, static::$select_string." username = '$username' LIMIT 1;");
            if (!$result) {
                return array('result' => 0);
            }
            while ($row = pg_fetch_row($result)) {
                return array('result' => 1, 'userId' => $payload->userId);

            }

            return array('result' => 0);

        } catch(Exception $e) {
            return array('result' => 0);
        }
    }

}

