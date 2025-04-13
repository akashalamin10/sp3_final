<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('bg23.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
           
            
        }

        .container {
            padding: 50px;
           
           
           
          
    font-family: Arial, sans-serif;
    color: white;
           
        }

        .top-right {
            display: flex;
           
            margin-top: 30px;
        }

        .top-right a {
            padding: 10px 20px;
            background-color: #2e3094;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        
        }

        .top-right a:hover {
            background-color:rgb(252, 176, 76);
            
        }

        .alert {
            padding: 15px;
            background-color: #f8d7da;
            color:rgb(161, 13, 25);
            border-radius: 5px;
            margin-top: 15px;
        }

       .form-section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 730px;
    padding: 20px;
  
    box-sizing: border-box;
}

.form-wrapper {
    background-color: rgba(255, 255, 255, 0.97);
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 480px;
    box-sizing: border-box;
    opacity:0.95;
}

.form-wrapper h2 {
    text-align: center;
    margin-bottom: 12px;
    font-size: 26px;
    color: #333;
}

.form-wrapper p {
    text-align: center;
    color: #6c757d;
    margin-bottom: 20px;
    font-size: 14px;
}

.form-wrapper select,
.form-wrapper input[type="id"],
.form-wrapper input[type="submit"] {
    width: 100%;
    padding: 14px 16px;
    margin: 10px 0;
    border-radius: 8px;
    font-size: 16px;
    border: 1px solid #ced4da;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-wrapper select:focus,
.form-wrapper input[type="id"]:focus {
    border-color: #2e3094;
    box-shadow: 0 0 5px rgba(46, 48, 148, 0.3);
}

.form-wrapper input[type="submit"] {
    background-color: #2e3094;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.form-wrapper input[type="submit"]:hover {
    background-color: rgb(252, 176, 76);
    color: #222;
}
footer {
        text-align: center;
        padding: 10px;
        font-size: 14px;
       
       
    }

        @media (max-width: 768px) {
            .form-wrapper {
                padding: 20px;
                border-radius: 10px;
            }

            .top-right {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="top-right">
            <a href="login.php">Login</a>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert">
                <?=($_SESSION['error']) ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <div class="form-wrapper">
                <h2>Daffodil International University</h2>
                <p>Student information</p>

                <form action="query_information.php" method="POST">
                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="CSE">CSE</option>
                        <option value="THM">THM</option>
                        <option value="SWE">SWE</option>
                        <option value="EEE">EEE</option>
                        <option value="NFE">NFE</option>
                        <option value="ENG">ENG</option>

                    </select>
                    <input type="id" name="roll" placeholder="Enter Your ID" required>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
            </div>
        </div>
    </div>
    <footer>
    2009-<?= date('Y')?> All Rights Reserved. Daffodil International University
</footer>


</body>
</html>


