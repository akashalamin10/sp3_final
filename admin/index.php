<?php include('header.php') ?>
<style>
    body {
        font-family: sans-serif;
      
      

       background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('bg21.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
        
    }

    .container {
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
        align-items:center;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        background-color:rgb(255, 255, 255);
        padding:20px;
        margin-top:200px;
        opacity: 0.8;
        border-radius: 5px;

       
    }

    .row {
        display: flex;
        
        background-color:rgba(207, 17, 17, 0);
       
       
    }

    .sidebar {
        width: 100%;
        max-width: 250px;
        margin-bottom: 20px;
        text-align: center;
      
    }

    .nav-link {
        display: flex;
        padding: 15px;
        background: #2e3094;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        
        text-decoration: none;
        color: white;
        border-radius: 5px;
        transition: 0.5s;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
       
    }

    .nav-link:hover {
        background-color: rgb(252, 176, 76);
    }

    .content {
        flex: 1;
        padding: 0 20px;
    }

    h1 {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .box {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        border: 1px solid #ccc;
        padding: 15px;
        margin: 10px 10px 10px 0;
        width: 100%;
        max-width: 300px;
        border-radius: 5px;
        margin-top:50px
    }

    .box h3 {
        margin: 0;
        font-size: 20px;
        color: #333;
      
    }

    .box p {
        margin: 5px 0 0;
        font-size: 14px bold;
        font-weight: 400px;
        color: red;
    }

    footer {
        text-align: center;
        padding: 10px;
        font-size: 14px;
       
       
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }

        .content {
            padding: 0;
        }
    }
</style>

<div class="container">
    <div class="row">
        
        <div class="sidebar">
            <a href="index.php" class="nav-link">Dashboard</a>
            <a href="add_student.php" class="nav-link">Add Student</a>
            <a href="all_students.php" class="nav-link">All Students</a>
            <a href="all_users.php" class="nav-link">Admins</a>
            <a href="all_users.php" class="nav-link">Teachers</a>
        </div>

      
        <div class="content">
            <h1> Dashboard</h1>
            <div class="row">
                <div class="box">
                    <?php
                        $sql = "SELECT * FROM `users`";
                        $query = mysqli_query($con, $sql);
                        $count_users = mysqli_num_rows($query);
                    ?>
                    <h3><?= $count_users ?></h3>
                    <p>All Admins</p>
                </div>

                <div class="box">
                    <?php
                        $sql = "SELECT * FROM `students`";
                        $query = mysqli_query($con, $sql);
                        $count_students = mysqli_num_rows($query);
                    ?>
                    <h3> <?= $count_students ?></h3>
                    <p>All Students</p>
                </div>

                <div class="box">
                    <?php
                        $sql = "SELECT * FROM `users`"; 
                        $query = mysqli_query($con, $sql);
                        $count_teachers = mysqli_num_rows($query);
                    ?>
                    <h3> <?= $count_teachers ?></h3>
                    <p>All Teachers</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    2009-<?= date('Y')?> All Rights Reserved. Daffodil International University
</footer>


