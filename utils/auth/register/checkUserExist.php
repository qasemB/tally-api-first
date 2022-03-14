<?php

$authMode = $_POST['auth_mode'];
$authModeTitle = $authMode == "mobile" ? "موبایل" : "ایمیل";
$authModeValue = $_POST[$authMode];

$oldUser = DB::query("SELECT * FROM users WHERE user_name = :user_name OR $authMode = :$authMode " , [
    ':user_name' => $_POST['user_name'],
    ":$authMode" => $authModeValue
]);

if (sizeof($oldUser) > 0) {
    $RepetitiousItem = $oldUser[0]['user_name'] == $_POST['user_name'] ? 'نام کاربری' : $authModeTitle;
    echo json_encode([
        'message' => "$RepetitiousItem تکراری است",
        'success'=> false,
    ]);
    die;
}