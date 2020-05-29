<?php
require "./controller/DbHandler.php";
use Db\DbHandler;
$db = new DbHandler();
$fighter_id = $_GET['id'];
$result = $db->select("SELECT name,age,catInfo,wins,loss,img FROM fighters WHERE id = '{$fighter_id}'");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFC</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous"
    />
</head>
<body class="row">
<h1 class="col-sm-10">CFC 3 - UPDATE FIGHTER</h1>
<a class="col-sm-2" href="./index.php" alt="home">GO BACK-></a>
<form class="container" action="./controller/db/Insert.php" method="post" enctype="multipart/form-data">
    <p class="from-group row">
        <label for="fname" class="col-sm-2 col-form-label">Name: </label>
        <input type="text" name="fname" id="fname" class="col-sm-10" value="<?=$row['name'];?>" required/>
    </p>
    <p class="from-group row">
        <label for="fage" class="col-sm-2 col-form-label">Age: </label>
        <input type="number" step=0.1 name="fage" id="fage" class="col-sm-10" value="<?=$row['age'];?>" required/>
    </p>
    <p class="from-group row">
        <label for="finfo" class="col-sm-2 col-from-label">Cat info: </label>
        <input type="text" name="finfo" id="finfo" class="col-sm-10" value="<?=$row['catInfo'];?>" required/>
    </p>
    <p class="from-group row">
        <label for="fwins" class="col-sm-2 col-from-label" >Wins: </label>
        <input type="number" name="fwins" id="fwins" class="col-sm-4" value="<?=$row['wins'];?>" required/>
        <label for="floss" class="col-sm-2 col-from-label">Loss: </label>
        <input type="number" name="floss" id="floss" class="col-sm-4" value="<?=$row['loss'];?>" required/>
    </p>
    <p class="from-group row">
        <label for="fimg" class="col-sm-2 col-from-label">Cat image: </label>
        <!--TODO set img-->
        <input type="file" id="fimg" name="fimg" class="col-sm-10" value="/img/<?=$row['img'];?>" required></input>
    </p>
    <p class="from-group row">
        <button type="submit" id="fsubmit" name="fsubmit" class="col-sm-12">SUBMIT</button>
    </p>
    <p class="from-group row">
        <button type="submit" id="btnDel" name="btnDel" class="col-sm-12">DELETE FIGHTER</button>
    </p>
</form>

</body>
</html>