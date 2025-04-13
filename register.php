<?php
include('config.php');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $Cpassword = mysqli_real_escape_string($con, $_POST['Cpassword']);
    $filename = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $size = $_FILES['photo']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'png', 'jpeg'];

    if (strlen($password) > 7) {
        if ($password === $Cpassword) {
            $sql = "SELECT * FROM `users` WHERE email = '$email'";
            $query = mysqli_query($con, $sql);
            $rows = mysqli_num_rows($query);
            if ($rows) {
                $email_exit = "Email already in use";
            } else {
                if (in_array($image_ext, $allow_type)) {
                    if ($size <= 2000000) {
                        move_uploaded_file($tmp_name, "upload/users/" . $filename);
                        $insert = "INSERT INTO `users`(`name`, `email`, `password`, `c_password`, `photo`) VALUES ('$name','$email','$password','$Cpassword','$filename')";
                        $insquery = mysqli_query($con, $insert);
                        if ($insquery) {
                            $successfull = "Registration successful!";
                        } else {
                            $failed = "Failed!";
                        }
                    } else {
                        $photo_error = "Image size should not be greater than 2MB";
                    }
                } else {
                    $photo_error = "Invalid image type. Only jpg, png & jpeg allowed.";
                }
            }
        } else {
            $pass_match = "Passwords do not match";
        }
    } else {
        $pass_lenght = "Password must be at least 8 characters";
    }
}
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('bg11.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.92);
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #198754;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #198754;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            margin-top: 20px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #157347;
        }

        .message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        .success {
            color: green;
        }

        .top-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-buttons a {
            text-decoration: none;
            color: white;
            background-color: #0d6efd;
            padding: 8px 14px;
            border-radius: 5px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            color: #666;
        }

        @media screen and (max-width: 500px) {
            .container {
                padding: 20px;
            }

            input[type="submit"] {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-buttons">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
        </div>
        <h2>User Registration</h2>

        <?php if (isset($successfull)): ?>
            <div class="message success"><?= $successfull ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter Your Name" maxlength="30" minlength="4" required>

            <input type="email" name="email" placeholder="Enter Your Email" maxlength="30" minlength="4" required>
            <?php if (isset($email_exit)) echo "<div class='message'>$email_exit</div>"; ?>

            <input type="password" name="password" placeholder="Enter Your Password" minlength="8" required>
            <?php if (isset($pass_lenght)) echo "<div class='message'>$pass_lenght</div>"; ?>

            <input type="password" name="Cpassword" placeholder="Confirm Password" minlength="8" required>
            <?php if (isset($pass_match)) echo "<div class='message'>$pass_match</div>"; ?>

            <label for="file">Select your photo</label>
            <input type="file" name="photo" id="file" required>
            <?php if (isset($photo_error)) echo "<div class='message'>$photo_error</div>"; ?>

            <input type="submit" name="submit" value="SUBMIT">
        </form>

        <div class="footer">
            2006-<?= date('Y') ?> All Rights Reserved. DIU
        </div>
    </div>
</body>
</html>

<?php include('footer.php'); ?>
