<?php

if ($method == 'GET') {
    
    require('./utils/auth/user/authCheck.php');

    $user = DB::query("SELECT * FROM users WHERE id = :id" , [
        ":id" => $user_id
    ]);

    $user = $user[0];
    unset($user['password']);
    unset($user['id']);
    unset($user['deleted_at']);
    echo json_encode([
        'user' => $user,
        'message' => 'کاربر با موفقیت دریافت شد',
        'success'=> true,
    ]);
            
        
} else{
    http_response_code(405);
}