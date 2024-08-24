<?php
include '../db.php';

if (isset($_GET['id'])) {
  $salary_id = $_GET['id'];
  $sql = "DELETE FROM salary WHERE salary_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $salary_id);
  mysqli_stmt_execute($stmt);

  header("Location: salary.php");
  exit;
}
?>