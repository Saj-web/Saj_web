<?php include 'templates/header.php';?>

<?php
include '../db.php';

$eval_id = $_GET['id'];

$sql = "SELECT * FROM evaluation WHERE eval_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eval_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$evaluation = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $employee_id = $_POST['employee_id'];
  $eval_value = $_POST['eval_value'];
  $notes = $_POST['notes'];

  $sql = "UPDATE evaluation SET employee_id = ?, eval_value = ?, notes = ? WHERE eval_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "issi", $employee_id, $eval_value, $notes, $eval_id);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('Evaluation updated successfully!');</script>";
    echo "<script>window.location.href='evaluation.php';</script>";
  } else {
    echo "<script>window.location.href='evaluation.php';</script>";
  }
}
?>

<style>
  form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input, textarea {
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
    border-radius: 5px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #3e8e41;
  }
</style>

<form method="post">
  <label for="employee_id">Employee ID:</label>
  <input type="number" id="employee_id" name="employee_id" value="<?php echo $evaluation['employee_id'];?>" readonly>

  <label for="eval_value">Evaluation Value:</label>
  <input type="text" id="eval_value" name="eval_value" value="<?php echo $evaluation['eval_value'];?>" required>

  <label for="notes">Notes:</label>
  <textarea id="notes" name="notes"><?php echo $evaluation['notes'];?></textarea>

  <input type="submit" value="Update Evaluation">
</form>

<?php include 'templates/footer.php';?>