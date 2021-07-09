<?php

error_reporting(E_ALL);

date_default_timezone_set('Europe/Budapest');

//define("SERVER_PATH", "https://serumcode.com");
//define("ORIGIN", "Access-Control-Allow-Origin: https://serumcode.com");

define("SERVER_PATH", "https://localhost");
define("ORIGIN", "Access-Control-Allow-Origin: *");


function returnOk()
{
    return array("status" => "OK", "message" => "A művelet sikeres.");
}

function retError($msg = "")
{
    return array("status" => "ERROR", "message" => "Hiba a művelet végrehajtása közben: " . $msg);
}

function retEx($ex)
{
    return array("status" => "ERROR", "message" => "Kivétel a művelet végrehajtása közben: " . $ex);
}


function sanitizeData($data){
    $data = htmlspecialchars(strip_tags($data));
    return $data;
}

function sanitizeObject($object)
{
    foreach ($object as $key => $value)
        if(is_string($value)&& !empty($value))
        $object->{$key} = htmlspecialchars(strip_tags($value));
    return $object;
}
function sanitizeObject_bp($object)
{
    foreach ($object as $key => $value)
        if(is_string($value) && !empty($value))
        $object->{$key} = htmlspecialchars(strip_tags($value, "<br><p><b>"));
    return $object;
}



function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
       // header("Access-Control-Allow-Origin: https://serumcode.com");
        header("Access-Control-Allow-Origin: http://localhost:8080");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        //header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
}