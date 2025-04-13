<?php 
    include('header.php');
    $search_text = $_GET['user_search'] ?? '';
    if (empty($search_text)) {
        header("location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        nav {
            width: 250px;
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav li {
            margin-bottom: 10px;
        }

        nav a {
            text-decoration: none;
            display: block;
            padding: 10px;
            background: #eee;
            color: #333;
            border-radius: 5px;
        }

        nav a:hover,
        nav .active a {
            background: #ddd;
        }

        main {
            flex-grow: 1;
            padding: 20px;
            background: #fff;
            margin-left: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-bar input[type="search"] {
            padding: 6px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 6px 10px;
            background: #666;
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
            background: white;
        }

        table thead {
            background: #eee;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .btn-profile {
            padding: 5px 10px;
            background: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-profile:hover {
            background: #148a9c;
        }

        .no-record {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            background: #eee;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="index.php">🏠 Dashboard</a></li>
                <li><a href="add_student.php">➕ Add Student</a></li>
                <li><a href="all_students.php">👨‍🎓 All Students</a></li>
                <li class="active"><a href="all_users.php">👥 All Admins</a></li>
            </ul>
        </nav>
        <main>
            <h2>👥 All Users</h2>
            <p>📍 Dashboard / All Users</p>

            <div class="search-bar">
                <h4>Search result for: <span style="color: green;"><?= htmlspecialchars($search_text) ?></span></h4>
                <form action="user_search.php" method="GET">
                    <input type="search" name="user_search" placeholder="Email" required maxlength="70" autocomplete="off">
                    <button type="submit">Search</button>
                </form>
            </div>

            <?php
                $sql = "SELECT * FROM `users` WHERE email LIKE '%$search_text%' ORDER BY date DESC";
                $query = mysqli_query($con, $sql);
                $rows = mysqli_num_rows($query);
                if ($rows > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>👤 Name</th>
                        <th>📧 Email</th>
                        <th>📅 Join Date</th>
                        <th>🔎 Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($query as $row): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= ucwords($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
                        <td><a class="btn-profile" href="user_profile.php?id=<?= $row['id'] ?>">👁️ View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="no-record">❌ No Record Found</div>
                <ul>
                    <li>✅ Check your spelling.</li>
                    <li>🔁 Try different keywords.</li>
                </ul>
            <?php endif; ?>
        </main>
    </div>
    <footer>
        © 2006-<?= date('Y') ?> All Rights Reserved. DIU
    </footer>
</body>
</html>
<?php include('footer.php'); ?>
