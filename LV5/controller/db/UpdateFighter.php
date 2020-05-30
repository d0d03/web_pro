<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fighter_id = $_GET['id'];
    $target_dir = "D:/xampp/htdocs/web_pro/LV5/img/";
    $fighter_name = $_POST['fname'];
    $fighter_age = $_POST['fage'];
    $fighter_info = $_POST['finfo'];
    $fighter_wins = $_POST['fwins'];
    $fighter_loss = $_POST['floss'];
    if(isset($_FILES['fimg']) && $_FILES['fimg']['name']!="") {
        $errors = array();
        $file_name = $_FILES['fimg']['name'];
        $file_size = $_FILES['fimg']['size'];
        $file_tmp = $_FILES['fimg']['tmp_name'];
        $ext = explode('.', $_FILES['fimg']['name']);
        $file_ext = strtolower(end($ext));

        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }
        if ($file_size > 204800) {
            $errors[] = 'File size must be excately 2 KB';
        }
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, $target_dir . $file_name);
            //echo "Success";
        } else {
            print_r($errors);
        }
        $db = new DbHandler();
        $db->update("UPDATE fighters SET name='{$fighter_name}', age='{$fighter_age}', catInfo='{$fighter_info}', wins='{$fighter_wins}', loss='{$fighter_loss}', img='{$file_name}' WHERE id='{$fighter_id}'");
    }else{
        $db = new DbHandler();
        $db->update("UPDATE fighters SET name='{$fighter_name}', age='{$fighter_age}', catInfo='{$fighter_info}', wins='{$fighter_wins}', loss='{$fighter_loss}' WHERE id='{$fighter_id}'");
    }
    header("Location: ../../index.php");
}
