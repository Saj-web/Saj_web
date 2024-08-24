<?php
include '../db.php';

if (isset($_GET['id'])) {
  $department_id = $_GET['id'];
  $sql = "SELECT * FROM department WHERE department_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $department_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if (isset($_POST['submit'])) {
    $department_name = $_POST['department_name'];
    $department_type = $_POST['department_type'];
    $department_description = $_POST['department_description'];

    $sql = "UPDATE department SET department_name = ?, department_type = ?, department_description = ? WHERE department_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $department_name, $department_type, $department_description, $department_id);
    mysqli_stmt_execute($stmt);

    header("Location: department.php");
    exit;
  }
}

?>

<style>
  body {
    font-family: Arial, sans-serif;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
  }

  input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #3e8e41;
  }
</style>

<h1>Edit Department</h1>

<form action="edit_department.php?id=<?php echo $department_id; ?>" method="post">
  <label for="department_name">Department Name:</label>
  <input type="text" id="department_name" name="department_name" value="<?php echo $row['department_name']; ?>"><br><br>
  <label for="department_type">Department Type:</label>
  <input type="text" id="department_type" name="department_type" value="<?php echo $row['department_type']; ?>"><br><br>
  <label for="department_description">Department Description:</label>
  <textarea id="department_description" name="department_description"><?php echo $row['department_description']; ?></textarea><br><br>
  <input type="submit" name="submit" value="Update Department">
</form>