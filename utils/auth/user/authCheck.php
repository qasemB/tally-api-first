<?php
$headers = apache_request_headers();

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode([
        'message' => 'Unauthorized',
        'success'=> false,
    ]);
    die;
}
$user_token = str_replace("Bearer ", '', $headers['Authorization']);
$tokenFields = DB::query("SELECT * FROM tokens WHERE token = :token " , [
    ':token' => $user_token
]);
if (sizeof($tokenFields) == 0) {
    echo json_encode([
        'message' => 'کاربر مورد نظر یافت نشد',
        'success'=> false,
    ]);
    die;
}
$tokenField = $tokenFields[0];
$user_id = $tokenField['user_id'];
$token = $tokenField['token'];
$exp = $tokenField['exp'];
$now = time();
if ($now > $exp) {
    DB::query("DELETE FROM tokens WHERE token = :token " , [
        ':token' => $user_token
    ]);
    echo json_encode([
        'message' => 'اعتبار توکن به اتمام رسیده',
        'success'=> false,
    ]);
    die;
}
