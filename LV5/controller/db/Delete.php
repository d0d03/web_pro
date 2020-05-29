<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

$fighter_id = $_GET['id'];
echo $fighter_id;

$db = new DbHandler();
$db->delete("$fighter_id");
header("Location: http://localhost/web_pro/LV5/index.php");