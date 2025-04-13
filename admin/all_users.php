<?php 
  include('header.php');
  if(!isset($_GET['page'])){
    $page = 1;
  }else{
    $page = $_GET['page'];
  }
  $limit = 5;
  $offset = ($page-1)*$limit;
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

  table th,
  table td {
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

  .btn-info {
    background-color: #17a2b8;
  }

  .pagination {
    display: flex;
    list-style: none;
    gap: 6px;
    padding: 0;
    margin-top: 10px;
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
    font-size: 13px;
    color: #666;
    background-color: #f1f1f1;
    margin-top: 10px;
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
      <a href="all_students.php">👥 All Students</a>
      <a href="all_users.php" class="active">👨‍💼 All Admins</a>
    </div>

    <div class="main">
      <h1>All Users</h1>
      <p class="breadcrumb">Dashboard / All Users</p>

      <div class="search-form">
        <form action="user_search.php" method="GET">
          <input type="text" name="user_search" required maxlength="70" placeholder="Email" autocomplete="off">
          <button type="submit">Search</button>
        </form>
      </div>

      <table>
        <thead>
          <tr>
            <th>Serial No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Join Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT * FROM `users` LIMIT $offset,$limit";
            $query = mysqli_query($con, $sql);
            $rows = mysqli_num_rows($query);
            if($rows){
              foreach($query as $row){
          ?>
          <tr>
            <td><?= ++$offset ?></td>
            <td><?= ucwords($row['name']) ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
            <td>
              <a href="user_profile.php?id=<?= $row['id'] ?>" class="btn btn-info">Profile</a>
            </td>
          </tr>
          <?php }} ?>
        </tbody>
      </table>

      <div style="display: flex; justify-content: space-between; margin-top: 10px;">
        <p>Showing 1 to <?= $rows ?> entries</p>
        <div>
          <?php
            $pagination = "SELECT * FROM `users`";
            $run_query = mysqli_query($con, $pagination);
            $total_user = mysqli_num_rows($run_query);
            $pages = ceil($total_user/$limit);
            if($total_user > $limit){
          ?>
          <ul class="pagination">
            <?php for ($i=1; $i<=$pages; $i++){ ?>
              <li class="<?= ($i==$page) ? 'active' : '' ?>">
                <a href="all_users.php?page=<?= $i ?>"><?= $i ?></a>
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
  <p>2006-<?= date('Y')?> All Rights Reserved. DIU</p>
</footer>

<?php include('footer.php'); ?>
