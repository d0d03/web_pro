<?php
require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $target_dir = "D:/xampp/htdocs/LV5/img/";
    $fighter_name = $_POST['fname'];
    $fighter_age = $_POST['fage'];
    $fighter_info = $_POST['finfo'];
    $fighter_wins = $_POST['fwins'];
    $fighter_loss = $_POST['floss'];
    if(isset($_FILES['fimg'])) {
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
    }
    $db = new DbHandler();
    $result = $db->select("SELECT * FROM fighters WHERE name='{$fighter_name}'");
    $num_rows = $result->num_rows;
    if($num_rows == 0){
        $db->insert("INSERT INTO fighters(name,age,catInfo,wins,loss,img) VALUES ('{$fighter_name}','{$fighter_age}','{$fighter_info}','{$fighter_wins}','{$fighter_loss}','{$file_name}')");
    }else{
        die("Fighter already exists.");
    }
    header("Location: http://localhost//lv5/index.php");
}


