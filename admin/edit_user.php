<?php
    include('../config.php');
    session_start();
    if(!isset($_SESSION['user_data'])){
        header('location: ../index.php');
        exit();
    }
    $user = $_SESSION['user_data'];

    $id = $_GET['id'] ?? '';
    if(empty($id)){
        header("location: index.php");
        exit();
    }

    $sql = "SELECT * FROM `users` WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query);

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $filename = $_FILES['photo']['name'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        $size = $_FILES['photo']['size'];
        $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allow_type = ['jpg','png','jpeg'];

        if(!empty($filename)){
            if(in_array($image_ext, $allow_type)){
                if($size <= 5000000){
                    $unlink = "../upload/users/" . $result['photo'];
                    if(file_exists($unlink)) unlink($unlink);
                    move_uploaded_file($tmp_name, "../upload/users/" . $filename);
                    $update = "UPDATE `users` SET `name`='$name', `photo`='$filename' WHERE id='$id'";
                    $insquery = mysqli_query($con, $update);
                    if($insquery){
                        header("location: all_users.php");
                        exit();
                    } else {
                        $failed = "Failed!";
                    }
                } else {
                    $photo_error = "Image size should not be greater than 2MB";
                }
            } else {
                $photo_error = "Only jpg, png & jpeg types are allowed";
            }
        } else {
            $update2 = "UPDATE `users` SET `name`='$name' WHERE id = '$id'";
            $insquery2 = mysqli_query($con, $update2);
            if($insquery2){
                header("location: all_users.php");
                exit();
            } else {
                $failed = "Failed!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .nav {
            background-color: #ffffff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }
        .nav a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="file"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #28a745;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="index.php">🏠 Dashboard</a>
        <a href="all_users.php">⬅ Back</a>
    </div>

    <div class="container">
        <?php if(isset($photo_error)) echo "<div class='alert'>$photo_error</div>"; ?>
        <?php if(isset($failed)) echo "<div class='alert'>$failed</div>"; ?>
        <h2>Update User Information</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($result['name']) ?>" maxlength="30" minlength="4" required>

            <label>Select Your Photo</label>
            <input type="file" name="photo">

            <input type="submit" name="submit" value="SUBMIT">
        </form>
    </div>

    <div class="footer">
        2009–<?= date('Y') ?> All Rights Reserved. Daffodil International University
    </div>
</body>
</html>
