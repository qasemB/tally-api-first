<?php

if ($method == 'POST') {
    if ($_POST !== null) {
        //validate data==================
        include('./utils/auth/register/validate.php');

        // check is exist user ==================
        include('./utils/auth/register/checkUserExist.php');
        
        // store user ==================
        include('./utils/auth/register/storeUser.php');
        
    }else{
        echo json_encode([
            'message' => 'please pill in all the credentials',
            'success'=> false,
        ]);
    }
} else{
    http_response_code(405);
}
