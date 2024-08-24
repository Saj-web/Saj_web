<?php
include '../db.php';

if (isset($_GET['id'])) {
  $training_id = $_GET['id'];
  $sql = "DELETE FROM trainings WHERE training_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $training_id);
  mysqli_stmt_execute($stmt);

  header("Location: training_view.php");
  exit;
}
?>