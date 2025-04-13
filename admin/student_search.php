<?php 
    include('header.php');
    $search_text = $_GET['student_search'] ?? '';
    if (empty($search_text)) {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .sidebar {
            float: left;
            width: 20%;
            padding-right: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li a {
            display: block;
            padding: 10px;
            background: #eee;
            margin-bottom: 5px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
        }

        .sidebar li a:hover {
            background: #ddd;
        }

        .content {
            float: left;
            width: 75%;
        }

        .header {
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .search-bar input[type="text"] {
            padding: 6px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 6px 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #f0f0f0;
        }

        .btn {
            padding: 5px 10px;
            font-size: 14px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        .btn-edit {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-profile {
            background: #007bff;
            color: white;
        }

        .no-record {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }

        footer {
            clear: both;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #555;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="index.php">📊 Dashboard</a></li>
                <li><a href="add_student.php">➕ Add Student</a></li>
                <li><a href="all_students.php">👨‍🎓 All Students</a></li>
                <li><a href="all_users.php">👥 All Admins</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="header">
                <h2>👨‍🎓 All Students</h2>
                <p>Search results for: <strong><?= htmlspecialchars($search_text) ?></strong></p>
            </div>

            <div class="search-bar">
                <form action="student_search.php" method="GET">
                    <input type="text" name="student_search" placeholder="Search Roll/Name" required maxlength="70">
                    <button type="submit">Search</button>
                </form>
            </div>

            <?php
                $sql = "SELECT * FROM `students` WHERE name LIKE '%$search_text%' OR roll LIKE '%$search_text%' ORDER BY time DESC";
                $query = mysqli_query($con, $sql);
                $rows = mysqli_num_rows($query);

                if ($rows > 0) {
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Roll</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Semester</th>
                                    <th>Shift</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $i = 1;
                    foreach ($query as $row) {
                        echo "<tr>
                                <td>{$i}</td>
                                <td>{$row['roll']}</td>
                                <td>" . ucwords($row['name']) . "</td>
                                <td>{$row['department']}</td>
                                <td>{$row['semester']}</td>
                                <td>{$row['shift']}</td>
                                <td>
                                    <a href='edit_students.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                    <form method='POST' action='' style='display:inline-block;' onsubmit='return confirm(\"Are you sure you want to delete?\")'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='hidden' name='image' value='{$row['file']}'>
                                        <input type='submit' name='delete' value='Delete' class='btn btn-delete'>
                                    </form>
                                    <a href='student_profile.php?id={$row['id']}' class='btn btn-profile'>Profile</a>
                                </td>
                            </tr>";
                        $i++;
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='no-record'>❌ No Record Found</div>
                          <ul>
                            <li>Check your spelling.</li>
                            <li>Try different or more general keywords.</li>
                          </ul>";
                }
            ?>
        </div>
    </div>

    <footer>
        &copy; 2006-<?= date('Y') ?> All Rights Reserved.DIU
    </footer>
</body>
</html>

<?php 
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $hidden_file = $_POST['image'];
    $unlink = "../upload/students/" . $hidden_file;
    $delete_student = "DELETE FROM `students` WHERE id = '$id'";
    $delete_query = mysqli_query($con, $delete_student);
    if ($delete_query) {
        if (file_exists($unlink)) {
            unlink($unlink);
        }
        header('Location: all_students.php');
    } else {
        echo "Failed to delete. Try again.";
    }
}
?>
