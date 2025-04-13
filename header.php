<?php

session_start();
include('config.php');
if(isset($_SESSION['user_data'])){
    header("location: admin/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daffodil International University</title>
    
</head>