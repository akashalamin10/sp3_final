<?php include('config.php'); ?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           height: 900px;
           background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('bg23.jpg') no-repeat center center;

        }

        .container {
           padding:50px;
           
        }

        .top-nav {
            display: flex;
          
            margin-top: 30px;
        }

        .top-nav a {
            padding: 10px 20px;
            background-color: #2e3094;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .top-nav a:hover {
            background-color: rgb(252, 176, 76);
        }

        .alert {
            margin-top: 15px;
            padding: 15px;
            background-color: #f8d7da;
            color: #842029;
            border-radius: 5px;
        }

        .center {
            display: flex;
            align-items: center;
            justify-content: center;
           height: 50%;
          
            padding: 20px;
        }

        .wrap {
            opacity:0.95;
    background-color: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 450px;
   margin-top: 120px;
    box-sizing: border-box;
}

h2 {
    text-align: center;
    margin-bottom: 24px;
    font-size: 28px;
    color: #333;
}

form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    font-size: 16px;
    margin-top: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s;
}

form input[type="email"]:focus,
form input[type="password"]:focus {
    border-color: #2e3094;
}

form input[type="submit"] {
    width: 100%;
    padding: 14px 16px;
    margin-top: 20px;
    font-size: 16px;
    background-color: #2e3094;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #fcb04c;
    color: #222;
}

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }

        @media (max-width: 600px) {
            .wrap {
                padding: 20px;
            }

            .top-nav {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-nav">
            <a href="index.php">Home</a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert">
                <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="center">
            <div class="wrap">
                <h2>ADMIN LOGIN</h2>
                <form action="" method="POST">
                    <input type="email" name="email" placeholder="Enter Your Email" required>
                    <input type="password" name="password" placeholder="Enter Your Password" required>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
            </div>
        </div>

        <p class="footer-text">2007-<?= date('Y') ?> All Right Reserved. Daffodil International University</p>
    </div>

  
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_num_rows($query);
    if ($row) {
        $record = mysqli_fetch_assoc($query);
        $user_data = array($record['name'], $record['id']);
        $_SESSION['user_data'] = $user_data;
        header('location: admin/index.php');
    } else {
        $_SESSION['error'] = "Invalid Username/Password";
        header("location: login.php");
    }
}
?>
