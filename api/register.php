<?php

if ($method == 'POST') {
    if ($_POST !== null) {

        include('./functions/auth/register/checkUserExist.php');

        DB::query("INSERT INTO users (user_name, first_name, last_name, email, mobile, password, gender, avatar) VALUES(:user_name, :first_name, :last_name, :email, :mobile, :password, :gender, :avatar)", [
            ':user_name' => $_POST['user_name'],
            ':first_name' => isset($_POST['first_name']) ? $_POST['first_name'] : "",
            ':last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : "",
            ':email' => isset($_POST['email']) ? $_POST['email'] : "",
            ':mobile' => isset($_POST['mobile']) ? $_POST['mobile'] : "",
            ':password' => password_hash($_POST['password'] , PASSWORD_DEFAULT),
            ':gender' => isset($_POST['gender']) ? $_POST['gender'] : "",
            ':avatar' => isset($_POST['avatar']) ? $_POST['avatar'] : "",
        ]);
        echo json_encode([
            'message' => 'user created successfully',
            'success'=> true,
        ]);
    }else{
        echo json_encode([
            'message' => 'please pill in all the credentials',
            'success'=> false,
        ]);
    }
} 
