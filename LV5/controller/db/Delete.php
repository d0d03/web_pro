<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

$fighter_id = &_GET['id'];

$db = new DbHandler();
//$db->delete("$fighter_id");