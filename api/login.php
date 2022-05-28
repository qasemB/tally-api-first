<?php

require('vendor/autoload.php');

use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

if ($method == 'POST') {
    if ($_POST !== null) {
        //validate data==================
        include('./utils/auth/login/validate.php');

        if (isset($_POST['mobile'])) {
            $authMode = "mobile";
            $authModeValue = $_POST['mobile'];
        }elseif(isset($_POST['email'])){
            $authMode = "email";
            $authModeValue = $_POST['email'];
        }else{
            echo json_encode([
                'message' => 'ایمیل یا موبایل به درستی وارد نشده است',
                'success'=> false,
            ]);
            die;
        }

        $users = DB::query("SELECT * FROM users WHERE $authMode = :$authMode" , [
            ":$authMode" => $authModeValue
        ]);

        if (sizeof($users) == 0) {
            echo json_encode([
                'message' => 'کاربر با این مشخصات یافت نشد',
                'success'=> false,
            ]);
            die;
        }else{
            $user = $users[0];
            $passOk = password_verify($_POST['password'],$user['password']);
            if (!$passOk) {
                echo json_encode([
                    'message' => 'پسوورد نادرست',
                    'success'=> false,
                ]);
                die;
            }else{
                try {
                    $iat = time();
                    $exp = $iat + 3600;
                    $payload = [
                        'iat' => $iat,
                        'exp' => $exp
                    ];
                    $key="";
                    $jwt = JWT::encode($payload, $key, 'HS512');
                    // $decoded = JWT::decode($jwt, new Key($this->key, 'HS512'));
                    DB::query("INSERT INTO tokens (user_id, token, exp) VALUES(:user_id, :token, :exp)", [
                        ':user_id' => $user['id'],
                        ':token' => $jwt,
                        ':exp' => $exp
                    ]);

                    echo json_encode([
                        'success'=> true,
                        'token' => $jwt,
                        'expire_time' => $exp,
                        'token_type' => 'Bearer',
                    ]);
                } catch (\Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => $e
                    ]);
                }
            }
        }


    }else{
        echo json_encode([
            'message' => 'please pill in all the credentials',
            'success'=> false,
        ]);
    }


} else{
    http_response_code(405);
}
