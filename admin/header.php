<?php
    include('../config.php');
    ob_start();
    define('student_management', true);
    session_start();
    if (!isset($_SESSION['user_data'])) {
        header('location: ../index.php');
        exit();
    }
    $user = $_SESSION['user_data'];

    $sql = "SELECT * FROM `users`";
    $query = mysqli_query($con, $sql);
    $profile_id = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height:100vh;
            

        }

        .nav {
          
            border-bottom: 1px solid #ccc;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav .brand {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 15px;
        background: #2e3094;
        border: transparent;
        }

        .nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
           
           
        }

        .nav ul li {
           
          display: block;
        padding: 10px 15px;
        background: #2e3094;
        border: 1px solid #ccc;
        margin-bottom: 8px;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        transition: 0.5s;
           
        }

        .nav ul li a {
          color:white;
            text-decoration: none;
            font-weight: 500;
           
           
        }

        .nav ul li:hover{
          background-color: rgb(252, 176, 76);

        }


        .nav ul li a.disabled {
            pointer-events: none;
            color: #888;
        }

        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav ul {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="nav">
        <a class="brand" href="index.php">Dashboard</a>
        <ul>
           
            <li><a href="register.php">Add Admin</a></li>
            <li><a href="user_profile.php?id=<?= $user[1] ?>">My Profile</a></li>
            <li><a href="exit.php">Exit</a></li>
        </ul>
    </div>
</body>
</html>
