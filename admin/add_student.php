<?php
include('../config.php');
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location: ../index.php');
}
$user = $_SESSION['user_data'];

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

    if (in_array($image_ext, $allow_type)) {
        if ($size <= 5000000) {
            $target = "../upload/students/" . $filename;
            if (move_uploaded_file($tmp_name, $target)) {
                $insert = "INSERT INTO `students`(`name`, `roll`, `department`, `semester`, `shift`, `father_name`, `mother_name`, `address`, `number`, `file`) 
                           VALUES ('$name','$roll','$department','$semister','$shift','$father_name','$mother_name','$address','$number','$filename')";
                $insquery = mysqli_query($con, $insert);
                if ($insquery) {
                    $successfull = "✅ Data inserted successfully!";
                } else {
                    $failed = "❌ Failed to insert data!";
                }
            } else {
                $failed = "❌ Failed to upload image!";
            }
        } else {
            $photo_error = "⚠️ Image size should not be more than 5MB.";
        }
    } else {
        $photo_error = "⚠️ Only JPG, PNG & JPEG files are allowed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
        }
        .navbar {
            background-color: #2f80ed;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 1rem;
            font-weight: bold;
        }
        .container {
            max-width: 700px;
            margin: 2rem auto;
            background-color: #fff;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #2f80ed;
            outline: none;
        }
        .btn-submit {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 0.8rem;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #219150;
        }
        .alert {
            padding: 1rem;
            background-color: #d4edda;
            border-left: 5px solid #28a745;
            margin-bottom: 1rem;
            color: #155724;
            border-radius: 8px;
        }
        .error { color: red; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="navbar">
    <div>DIU Student Panel</div>
    <div>
        <a href="../index.php">Dashboard</a>
        <a href="login.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Add Student Information</h2>

    <?php if (isset($successfull)): ?>
        <div class="alert"><?php echo $successfull; ?></div>
    <?php elseif (isset($failed)): ?>
        <div class="alert" style="background-color:#f8d7da;border-left:5px solid #dc3545;color:#721c24;"><?php echo $failed; ?></div>
    <?php elseif (isset($photo_error)): ?>
        <div class="alert" style="background-color:#fff3cd;border-left:5px solid #ffc107;color:#856404;"><?php echo $photo_error; ?></div>
    <?php endif; ?>

    <form id="registrationForm" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name">
        <span id="nameError" class="error"></span>

        <input type="text" name="roll" id="roll" class="form-control" placeholder="Enter Your ID">
        <span id="rollError" class="error"></span>

        <select name="department" id="department" class="form-control">
            <option value="">Select Department</option>
            <option value="CSE">CSE</option>
            <option value="SWE">SWE</option>
            <option value="EEE">EEE</option>
            <option value="NFE">NFE</option>
            <option value="ENG">ENG</option>
            <option value="THM">THM</option>
        </select>
        <span id="departmentError" class="error"></span>

        <select name="semister" id="semister" class="form-control">
            <option value="">Select Semester</option>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>th"><?= $i ?>th</option>
            <?php endfor; ?>
        </select>
        <span id="semisterError" class="error"></span>

        <select name="shift" id="shift" class="form-control">
            <option value="">Select Shift</option>
            <option value="Morning">Morning</option>
            <option value="Evening">Evening</option>
        </select>
        <span id="shiftError" class="error"></span>

        <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Enter Father's Name">
        <span id="fatherNameError" class="error"></span>

        <input type="text" name="mother_name" id="mother_name" class="form-control" placeholder="Enter Mother's Name">
        <span id="motherNameError" class="error"></span>

        <input type="text" name="address" id="address" class="form-control" placeholder="Enter Upazila & Zila Name">
        <span id="addressError" class="error"></span>

        <input type="text" name="number" id="number" class="form-control" placeholder="Enter Your Number">
        <span id="numberError" class="error"></span>

        <label for="file">📷 Upload Photo</label>
        <input type="file" name="file" id="file" class="form-control">
        <span id="fileError" class="error"></span>

        <label><input type="checkbox" id="terms"> I agree to the terms and conditions</label>
        <span id="termsError" class="error"></span><br><br>

        <input type="submit" name="submit" value="SUBMIT" class="btn-submit">
    </form>
</div>

<script>
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    let valid = true;
    const get = id => document.getElementById(id);
    
    const name = get('name').value.trim();
    if (name === '' || !/^[a-zA-Z\s]+$/.test(name)) {
        get('nameError').textContent = 'Please enter a valid name.';
        valid = false;
    } else get('nameError').textContent = '';

    const roll = get('roll').value.trim();
    if (roll === '' || !/^\d{3}-\d{2}-\d{4}$/.test(roll)) {
        get('rollError').textContent = 'Please enter a valid ID (e.g., 123-45-6789).';
        valid = false;
    } else get('rollError').textContent = '';

    ['department', 'semister', 'shift'].forEach(field => {
        if (get(field).value === '') {
            get(field + 'Error').textContent = 'This field is required.';
            valid = false;
        } else get(field + 'Error').textContent = '';
    });

    ['father_name', 'mother_name'].forEach(field => {
        const val = get(field).value.trim();
        if (val === '' || !/^[a-zA-Z\s]+$/.test(val)) {
            get(field + 'Error').textContent = 'Please enter a valid name.';
            valid = false;
        } else get(field + 'Error').textContent = '';
    });

    if (get('address').value.trim() === '') {
        get('addressError').textContent = 'Please enter your address.';
        valid = false;
    } else get('addressError').textContent = '';

    const number = get('number').value.trim();
    if (number === '' || !/^01\d{9}$/.test(number)) {
        get('numberError').textContent = 'Please enter a valid Bangladeshi number.';
        valid = false;
    } else get('numberError').textContent = '';

    const filePath = get('file').value;
    if (filePath === '' || !/\.(jpg|jpeg|png)$/i.test(filePath)) {
        get('fileError').textContent = 'Please upload a valid image file.';
        valid = false;
    } else get('fileError').textContent = '';

    if (!get('terms').checked) {
        get('termsError').textContent = 'You must agree to the terms.';
        valid = false;
    } else get('termsError').textContent = '';

    if (!valid) event.preventDefault();
});
</script>

</body>
</html>
