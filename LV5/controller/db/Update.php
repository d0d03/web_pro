<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

$fighter1_name = $_POST["name1"];
$fighter2_name = $_POST["name2"];
$outcome = $_POST["results"];
$db = new DbHandler();
if($outcome == "1,0"){
    $db->update("UPDATE fighters SET wins=wins+1 WHERE name='{$fighter2_name}'");
    $db->update("UPDATE fighters SET loss=loss+1 WHERE name='{$fighter1_name}'");
}else{
    $db->update("UPDATE fighters SET wins=wins+1 WHERE name='{$fighter1_name}'");
    $db->update("UPDATE fighters SET loss=loss+1 WHERE name='{$fighter2_name}'");
}

$response = [];
$response[0] = $db->select("SELECT * FROM fighters WHERE name ='{$fighter1_name}'");
$response[1] = $db->select("SELECT * FROM fighters WHERE name ='{$fighter2_name}'");
return $response;