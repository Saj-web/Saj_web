<?php include 'templates/header.php';?>

<?php
include '../db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $employee_name = $_POST['employee_name'];
  $eval_value = $_POST['eval_value'];
  $notes = $_POST['notes'];

    // Get the employee ID from the employee table
    $sql = "SELECT employee_id FROM employee WHERE employee_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee_id = $result->fetch_assoc()['employee_id'];

  $sql = "INSERT INTO evaluation (employee_id, eval_value, notes) VALUES (?,?,?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iss", $employee_id, $eval_value, $notes);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('Evaluation added successfully!');</script>";
    echo "<script>window.location.href='evaluation.php';</script>";
  } else {
    echo "<script>alert('Error adding evaluation!');</script>";
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
  <label for="employee_name">Employee Name:</label>
  <input type="text" id="employee_name" name="employee_name" required>

  <label for="eval_value">Evaluation Value:</label>
  <input type="text" id="eval_value" name="eval_value" required>

  <label for="notes">Notes:</label>
  <textarea id="notes" name="notes"></textarea>

  <input type="submit" value="Add Evaluation">
</form>

<?php include 'templates/footer.php';?>