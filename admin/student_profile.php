<?php
include('../config.php');
$id = $_GET['id'];
if (empty($id)) {
    header("location: index.php");
}
$sql = "SELECT * FROM `students` WHERE id = '$id'";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucwords($result['name']) ?> - Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
  body {
    background: #f2f2f2;
    font-family: Arial, sans-serif;
    padding: 20px;
    margin: 0;
}

.card {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    padding: 25px;
}

.banner {
    text-align: center;
    margin-bottom: 20px;
}

.profile {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #3498db;
}

.name {
    font-size: 24px;
    margin-top: 10px;
    color: #333;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.info-table th,
.info-table td {
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.info-table th {
    background-color: #f9f9f9;
    color: #333;
    width: 40%;
    font-weight: normal;
}

.info-table td {
    color: #555;
}

.footer {
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 0 8px;
    font-size: 14px;
    color: #fff;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn.back {
    background-color: #3498db;
}

.btn.back:hover {
    background-color: #2980b9;
}

.btn.logout {
    background-color: #e74c3c;
}

.btn.logout:hover {
    background-color: #c0392b;
}

    </style>
</head>
<body>
<div class="card">
    <div class="banner">
        <img class="profile" src="../upload/students/<?= $result['file'] ?>" alt="Profile Picture">
        <h2 class="name"><?= ucwords($result['name']) ?></h2>
    </div>
    <table class="info-table">
        <tr><th> ID</th><td><?= $result['roll'] ?></td></tr>
        <tr><th> Department</th><td><?= $result['department'] ?></td></tr>
        <tr><th> Semester</th><td><?= $result['semester'] ?></td></tr>
        <tr><th> Shift</th><td><?= $result['shift'] ?></td></tr>
        <tr><th> Father</th><td><?= ucwords($result['father_name']) ?></td></tr>
        <tr><th> Mother</th><td><?= ucwords($result['mother_name']) ?></td></tr>
        <tr><th> Address</th><td><?= ucwords($result['address']) ?></td></tr>
        <tr><th> Phone</th><td><?= $result['number'] ?></td></tr>
    </table>
    <div class="footer">
        <a href="all_students.php" class="btn back"> Back</a>
        <a href="exit.php" class="btn logout"> Logout</a>
    </div>
</div>

</body>
</html>
