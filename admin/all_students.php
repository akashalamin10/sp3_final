<?php 
  include('header.php'); // Make sure this connects to DB and starts session

  // Error reporting for debugging (optional)
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Pagination setup
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $limit = 5;
  $offset = ($page - 1) * $limit;
?>

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
  }
  .container-fluid {
    display: flex;
    flex-direction: row;
    gap: 20px;
    padding: 20px;
  }
  .sidebar {
    width: 220px;
    background-color: #ffffff;
    border-right: 1px solid #ddd;
    padding: 15px 10px;
  }
  .sidebar a {
    display: block;
    padding: 12px;
    margin-bottom: 8px;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: background-color 0.3s ease;
  }
  .sidebar a:hover,
  .sidebar a.active {
    background-color: #007bff;
    color: white;
  }
  .main {
    flex: 1;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  h1 {
    color: #007bff;
    font-size: 24px;
    margin-bottom: 10px;
  }
  .breadcrumb {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
  }
  .search-form {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
  }
  .search-form input[type="text"] {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px 0 0 4px;
    width: 200px;
  }
  .search-form button {
    padding: 6px 12px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
  }
  .search-form button:hover {
    background-color: #5a6268;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }
  table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
  }
  table th {
    background-color: #f1f1f1;
  }
  .btn {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    text-decoration: none;
    color: white;
    cursor: pointer;
    margin-right: 5px;
  }
  .btn-success { background-color: #28a745; }
  .btn-danger  { background-color: #dc3545; }
  .btn-info    { background-color: #17a2b8; }
  .pagination {
    display: flex;
    list-style: none;
    gap: 6px;
    padding: 0;
  }
  .pagination li a {
    padding: 6px 10px;
    border: 1px solid #ccc;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
  }
  .pagination li.active a {
    background-color: #007bff;
    color: white;
  }
  footer {
    text-align: center;
    padding: 10px 0;
    margin-top: 10px;
    font-size: 13px;
    color: #666;
    background-color: #f1f1f1;
  }
  @media (max-width: 768px) {
    .container-fluid {
      flex-direction: column;
    }
    .sidebar {
      width: 100%;
      border-right: none;
    }
  }
</style>

<section class="mt-3">
  <div class="container-fluid">
    <div class="sidebar">
      <a href="index.php">🏠 Dashboard</a>
      <a href="add_student.php">➕ Add Student</a>
      <a href="all_students.php" class="active">👥 All Students</a>
      <a href="all_users.php">👨‍💼 All Admins</a>
    </div>

    <div class="main">
      <h1>All Students</h1>
      <p class="breadcrumb">Dashboard / All Students</p>

      <div class="search-form">
        <form action="student_search.php" method="GET">
          <input type="text" name="student_search" required maxlength="70" placeholder="ID/Name" autocomplete="off">
          <button type="submit">Search</button>
        </form>
      </div>

      <table>
        <thead>
          <tr>
            <th>Serial No.</th>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Semester</th>
            <th>Shift</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT * FROM `students` ORDER BY id DESC LIMIT $offset, $limit";
            $query = mysqli_query($con, $sql);
            if (!$query) {
              echo "<tr><td colspan='7'>Query Error: " . mysqli_error($con) . "</td></tr>";
            } else {
              $rows = mysqli_num_rows($query);
              if ($rows > 0) {
                $serial = $offset + 1;
                while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td><?= $serial++ ?></td>
            <td><?= $row['roll'] ?></td>
            <td><?= ucwords($row['name']) ?></td>
            <td><?= $row['department'] ?></td>
            <td><?= $row['semester'] ?></td>
            <td><?= $row['shift'] ?></td>
            <td>
              <a href="edit_students.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
              <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete?')">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="image" value="<?= $row['file'] ?>">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
              </form>
              <a href="student_profile.php?id=<?= $row['id'] ?>" class="btn btn-info">Profile</a>
            </td>
          </tr>
          <?php } } else {
              echo "<tr><td colspan='7'>No students found.</td></tr>";
            } } ?>
        </tbody>
      </table>

      <div style="display: flex; justify-content: space-between; margin-top: 10px;">
        <p>Showing <?= $offset+1 ?> to <?= $offset+$rows ?> entries</p>
        <div>
          <?php
            $pagination_query = "SELECT COUNT(*) AS total FROM `students`";
            $pagination_result = mysqli_query($con, $pagination_query);
            $total_students = mysqli_fetch_assoc($pagination_result)['total'];
            $pages = ceil($total_students / $limit);
            if ($pages > 1) {
          ?>
          <ul class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++) { ?>
              <li class="<?= ($i == $page) ? 'active' : '' ?>">
                <a href="all_students.php?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <p>2006-<?= date('Y') ?> All Rights Reserved. DIU</p>
</footer>

<?php 
  include('footer.php');
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $hidden_file = $_POST['image'];
    $unlink = "../upload/students/" . $hidden_file;
    $delete_student = "DELETE FROM `students` WHERE id = '$id'";
    $delete_query = mysqli_query($con, $delete_student);
    if ($delete_query) {
      if (!empty($hidden_file) && file_exists($unlink)) {
        unlink($unlink);
      }
      header('Location: all_students.php');
      exit;
    } else {
      echo "<script>alert('Failed to delete student.');</script>";
    }
  }
?>
