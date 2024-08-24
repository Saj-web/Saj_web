<?php include 'templates/header.php'; ?>

<?php
include '../db.php';

if (isset($_POST['submit'])) {
  $department_id = $_POST['department_id'];
  $department_name = $_POST['department_name'];
  $department_type = $_POST['department_type'];
  $department_description = $_POST['department_description'];

  $sql = "INSERT INTO department (department_id, department_name, department_type, department_description) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isss", $department_id, $department_name, $department_type, $department_description);
  mysqli_stmt_execute($stmt);

  header("Location: department.php");
  exit;
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

<h1>Add Department</h1>

<form action="add_department.php" method="post">
  <label for="department_id">Department ID:</label>
  <input type="text" id="department_id" name="department_id" required><br><br>
  <label for="department_name">Department Name:</label>
  <input type="text" id="department_name" name="department_name" required><br><br>
  <label for="department_type">Department Type:</label>
  <input type="text" id="department_type" name="department_type" required><br><br>
  <label for="department_description">Department Description:</label>
  <textarea id="department_description" name="department_description" required></textarea><br><br>
  <input type="submit" name="submit" value="Add Department">
</form>