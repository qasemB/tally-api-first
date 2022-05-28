<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
header('Access-Control-Allow-Headers: Accept, Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

// define varables
$tables = ['bills', 'consumers', 'groups', 'group_user', 'roles', 'role_user', 'tokens', 'user'];
$id = null;
$queryStr = null;
$method = $_SERVER['REQUEST_METHOD'];

//get uri
$request_uri = $_SERVER['REQUEST_URI'];


// clear url
$url = rtrim($request_uri, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

//query string management --------
$urlArr = explode('?', $url);
if (sizeof($urlArr) > 1) {
    $queryStr = $urlArr[1];
    $url = $urlArr[0];
}

//segmentation url (ex: localhost/project_name/api/table_name/item_id)
$url = explode('/', $url);

$tableName = (string) $url[3];

if (isset($url[4]) && $url[4] != null) {
    $id = (int) $url[4];
}


if ($tableName == "login") {
    include_once './classes/Database.php';
    include_once './api/login.php';
} elseif ($tableName == "register") {
    include_once './classes/Database.php';
    include_once './api/register.php';
} elseif (in_array($tableName, $tables)) {
    include_once './classes/Database.php';
    include_once './api/' . $tableName . '.php';
} else {
    echo 'Table does not exist';
}
