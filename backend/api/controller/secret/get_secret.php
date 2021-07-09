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

$secret->hash = isset($postData->hash) ? $postData->hash : "";

date_default_timezone_set('Europe/Budapest');

$err = "";
if($secret->hash ==='')
    $err .= "Nincs hash megadva";


if (!empty($err)) {
    echo json_encode(retError($err));
    return false;
}


if ($secret->getSecret() && $secret->updateSecret()) {
    http_response_code(200);
    if( date("Y-m-d H:i:s") > $secret->date){
        
        echo json_encode(retError("Lejárt az idő"));
    }
    else if( $secret->expireAfterViews < $secret->views){
        
        echo json_encode(retError("A megtekintések száma elérte a maximumot"));
    }else{
     
    
    echo json_encode(
                array(
                    "status" => "OK",
                    "message" => "Sikeres lekérés.",
                    "id" => $secret->id,
                    "expireAfterViews" => $secret-> expireAfterViews,
                    "secret" => $secret-> secret,
                    "expireAfter" => $secret-> expireAfter,
                    "views" => $secret-> views,
                    "date" => $secret-> date,
                 
                )
        );
    }

} else {
    http_response_code(400);
    echo json_encode(retError("A lekérés sikertelen."));
}