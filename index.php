<?php
include_once "apiLib.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response = [];

if (isset($_GET) && isset($_GET['_t']) && isset($_GET['_u'])) {
    $type = $_GET['_t'];
    $username = $_GET['_u'];

    $api = new apiLib($username);

    switch ($type) {
        case 'search':
            $response = [];
            break;
        case 'media':
            $response = $api->getMedias();
            break;
        case 'account':
            $response = $api->getAccount();
            break;
        default:
            $response = [];
            break;
    }
}

$json_response = json_encode($response);
echo $json_response;
