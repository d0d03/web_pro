<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

$fighter_id = $_POST['id'];
echo $fighter_id;

$db = new DbHandler();
$db->delete("$fighter_id");
header("Location: ../../index.php");