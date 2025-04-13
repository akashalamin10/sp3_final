<?php
include('../config.php');
session_start();
if (isset($_SESSION['user_data'])) {
    $user = $_SESSION['user_data'];
} else {
    header('location: ../index.php');
}
$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("location: index.php");
}
$sql = "SELECT * FROM `students` WHERE id = '$id'";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $roll = mysqli_real_escape_string($con, $_POST['roll']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $semister = mysqli_real_escape_string($con, $_POST['semister']);
    $shift = mysqli_real_escape_string($con, $_POST['shift']);
    $father_name = mysqli_real_escape_string($con, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($con, $_POST['mother_name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $filename = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'png', 'jpeg'];

    if (!empty($filename)) {
        if (in_array($image_ext, $allow_type)) {
            if ($size <= 5000000) {
                $unlink = "../upload/students/" . $result['file'];
                unlink($unlink);
                move_uploaded_file($tmp_name, "../upload/students/" . $filename);
                $update = "UPDATE `students` SET `name`='$name',`roll`='$roll',`department`='$department',`semester`='$semister',`shift`='$shift',`father_name`='$father_name',`mother_name`='$mother_name',`address`='$address',`number`='$number',`file`='$filename' WHERE id = '$id'";
                if (mysqli_query($con, $update)) {
                    header("location: all_students.php");
                } else {
                    echo "Failed!";
                }
            } else {
                echo "Image size should not be greater than 2MB";
            }
        } else {
            echo "Image file type is not allowed (Only jpg, png & jpeg)";
        }
    } else {
        $update2 = "UPDATE `students` SET `name`='$name',`roll`='$roll',`department`='$department',`semester`='$semister',`shift`='$shift',`father_name`='$father_name',`mother_name`='$mother_name',`address`='$address',`number`='$number' WHERE id = '$id'";
        if (mysqli_query($con, $update2)) {
            header("location: all_students.php");
        } else {
            echo "Failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
        }
        nav .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        form input, form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        form label {
            font-weight: bold;
        }
        form input[type="submit"] {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            padding: 10px;
            margin-top: 40px;
            background-color: #eee;
            color: #555;
        }
        @media(max-width: 600px){
            nav {
                flex-direction: column;
                align-items: center;
            }
            nav .nav-links {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div><strong>DIU</strong></div>
        <div class="nav-links">
           
            <a href="register.php">Add Admin</a>
            <a href="#">My Profile</a>
            <a href="all_students.php">Back</a>
        </div>
    </nav>

    <div class="container">
        <h2>Update Student Information</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" value="<?= $result['name'] ?>" placeholder="Enter Your Name" required>
            <input type="text" name="roll" value="<?= $result['roll'] ?>" placeholder="Enter Your Roll" required>
            <select name="department" required>
                <option value="<?= $result['department'] ?>" selected><?= $result['department'] ?></option>
                <option value="CSE">CSE</option>
                <option value="SWE">SWE</option>
                <option value="EEE">EEE</option>
                <option value="NFE">NFE</option>
                <option value="ENG">ENG</option>
            </select>
            <select name="semister" required>
                <option value="<?= $result['semester'] ?>" selected><?= $result['semester'] ?></option>
                <?php for($i=1; $i<=8; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <select name="shift" required>
                <option value="<?= $result['shift'] ?>" selected><?= $result['shift'] ?></option>
                <option value="1st">1st Shift</option>
            </select>
            <input type="text" name="father_name" value="<?= $result['father_name'] ?>" placeholder="Enter Father's Name" required>
            <input type="text" name="mother_name" value="<?= $result['mother_name'] ?>" placeholder="Enter Mother's Name" required>
            <input type="text" name="address" value="<?= $result['address'] ?>" placeholder="Enter Address" required>
            <input type="number" name="number" value="<?= $result['number'] ?>" placeholder="Enter Phone Number" required>
            <label for="file">Select Photo:</label>
            <input type="file" name="file" id="file">
            <input type="submit" name="submit" value="Update">
        </form>
    </div>

    <div class="footer">
        © 2006-<?= date('Y') ?> All Rights Reserved. Daffodil International university
    </div>
</body>
</html>
