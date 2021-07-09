<?php
include_once "../../config/Database.php";
include_once "../../config/Core.php";
include_once "../../model/Secret.php";

cors();
header(ORIGIN);

$database = new Database();
$db = $database->GetConnection();

$secret = new Secret($db);

$postData = sanitizeObject(json_decode(file_get_contents('php://input')));

$secret->secret = isset($postData->secret) ? $postData->secret : "";
$secret->expireAfterViews = isset($postData->expireAfterViews)? $postData->expireAfterViews :"";
$secret->expireAfter = isset($postData->expireAfter)? $postData->expireAfter : "";
$secret->hash = md5(uniqid(rand(), true));
date_default_timezone_set('Europe/Budapest');

$secret->date=  date("Y-m-d H:i:s", strtotime("+". strval($secret->expireAfter) . " minutes"));


while($database->valueExists($secret->tableName, "hash", $secret->hash)){
    $secret->hash = md5(uniqid(rand(), true));
}
$err = "";
if ($secret->secret==='' || $secret->expireAfterViews ==='' || $secret->expireAfter==='')
    $err .= "Minden mező kitöltése kötelező";


if (!empty($err)) {
    echo json_encode(retError($err));
    return false;
}


if ($secret->createSecret()) {


    http_response_code(200);
    echo json_encode(
                array(
                    "status" => "OK",
                    "message" => "Sikeres hozzáadás.",
                    "hash" => $secret-> hash,
                 
                )
        );
  
} else {
    http_response_code(400);
    echo json_encode(retError("A hozzáadás sikertelen."));
}