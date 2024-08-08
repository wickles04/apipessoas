<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json, charset=utf-8");

echo json_encode($array,JSON_UNESCAPED_UNICODE); //desafio acrescentar o JSON_UNESCAPED_UNICODE 
exit;


?>