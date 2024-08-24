<?php
include '../db.php';

if (isset($_POST['submit'])) {
  $salary_id = $_POST['salary_id'];
  $employee_name = $_POST['employee_name'];
  $salary_amount = $_POST['salary_amount'];
  $salary_total = $_POST['salary_total'];
  $salary_type = $_POST['salary_type'];
  $salary_description = $_POST['salary_description'];

  // Get employee_id from employee table
  $sql_employee = "SELECT employee_id FROM employee WHERE employee_name = ?";
  $stmt_employee = mysqli_prepare($conn, $sql_employee);
  mysqli_stmt_bind_param($stmt_employee, "s", $employee_name);
  mysqli_stmt_execute($stmt_employee);
  $result_employee = mysqli_stmt_get_result($stmt_employee);
  $row_employee = mysqli_fetch_assoc($result_employee);
  $employee_id = $row_employee['employee_id'];

  // Insert into salary table
  $sql = "INSERT INTO salary (salary_id, employee_id, salary_amount, salary_total, salary_type, salary_description) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iisiss", $salary_id, $employee_id, $salary_amount, $salary_total, $salary_type, $salary_description);
  mysqli_stmt_execute($stmt);

  header("Location: salary.php");
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

<h1>Add Salary</h1>

<form action="add_salary.php" method="post">
  <label for="salary_id">Salary ID:</label>
  <input type="text" id="salary_id" name="salary_id" required><br><br>
  <label for="employee_name">Employee Name:</label>
  <input type="text" id="employee_name" name="employee_name" required><br><br>
  <label for="salary_amount">Salary Amount:</label>
  <input type="text" id="salary_amount" name="salary_amount" required><br><br>
  <label for="salary_total">Salary Total:</label>
  <input type="text" id="salary_total" name="salary_total" required><br><br>
  <label for="salary_type">Salary Type:</label>
  <input type="text" id="salary_type" name="salary_type" required><br><br>
  <label for="salary_description">Salary Description:</label>
  <textarea id="salary_description" name="salary_description" required></textarea><br><br>
  <input type="submit" name="submit" value="Add Salary">
</form>