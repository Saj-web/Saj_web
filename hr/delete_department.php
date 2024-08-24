<?php
include '../db.php';

if (isset($_GET['id'])) {
  $department_id = $_GET['id'];
  $sql = "DELETE FROM department WHERE department_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $department_id);
  mysqli_stmt_execute($stmt);

  header("Location: department.php");
  exit;
}
?>