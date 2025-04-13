<?php
    include('../config.php');
    $id = $_GET['id'] ?? '';
    if (empty($id)) {
        header("Location: index.php");
        exit();
    }
    $sql = "SELECT * FROM `users` WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .card {
            max-width: 400px;
            background: white;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .banner {
            margin-bottom: 20px;
        }

        .banner img.profile {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ccc;
        }

        h2.name {
            margin: 10px 0 5px;
            font-size: 24px;
            color: #333;
        }

        .title {
            margin: 8px 0;
            font-size: 16px;
            color: #666;
        }

        .footer {
            margin-top: 20px;
        }

        .footer a {
            text-decoration: none;
            margin: 0 8px;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            color: white;
        }

        .footer .edit {
            background: #28a745;
        }

        .footer .back {
            background: #6c757d;
        }

        .footer a:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="banner">
            <img class="profile" src="../upload/users/<?= $row['photo'] ?>" alt="User Photo">
        </div>
        <h2 class="name"><?= ucwords($row['name']) ?></h2>
        <div class="title">📧 Email: <?= htmlspecialchars($row['email']) ?></div>
        <div class="title">📅 Join Date: <?= date("d-m-Y", strtotime($row['date'])) ?></div>
        <div class="footer">
            <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit">✏️ Edit</a>
            <a href="all_users.php" class="back">🔙 Back</a>
        </div>
    </div>
</body>
</html>
