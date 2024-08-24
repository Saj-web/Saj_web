<?php
include '../db.php';

$eval_id = $_GET['id'];

$sql = "DELETE FROM evaluation WHERE eval_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eval_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
  echo "<script>alert('Evaluation deleted successfully!');</script>";
  echo "<script>window.location.href='evaluation.php';</script>";
} else {
  echo "<script>alert('Error deleting evaluation!');</script>";
  echo "<script>window.location.href='evaluation.php';</script>";
}

mysqli_close($conn);
?>