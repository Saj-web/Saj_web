<?php
include '../db.php';

if (isset($_GET['id'])) {
  $salary_id = $_GET['id'];
  $sql = "SELECT * FROM salary WHERE salary_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $salary_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if (isset($_POST['submit'])) {
    $salary_amount = $_POST['salary_amount'];
    $salary_total = $_POST['salary_total'];
    $salary_type = $_POST['salary_type'];
    $salary_description = $_POST['salary_description'];

    $sql = "UPDATE salary SET salary_amount = ?, salary_total = ?, salary_type = ?, salary_description = ? WHERE salary_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $salary_amount, $salary_total, $salary_type, $salary_description, $salary_id);
    mysqli_stmt_execute($stmt);

    header("Location: salary.php");
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

<h1>Edit Salary</h1>

<form action="edit_salary.php?id=<?php echo $salary_id; ?>" method="post">
  <label for="salary_amount">Salary Amount:</label>
  <input type="text" id="salary_amount" name="salary_amount" value="<?php echo $row['salary_amount']; ?>"><br><br>
  <label for="salary_total">Salary Total:</label>
  <input type="text" id="salary_total" name="salary_total" value="<?php echo $row['salary_total']; ?>"><br><br>
  <label for="salary_type">Salary Type:</label>
  <input type="text" id="salary_type" name="salary_type" value="<?php echo $row['salary_type']; ?>"><br><br>
  <label for="salary_description">Salary Description:</label>
  <textarea id="salary_description" name="salary_description"><?php echo $row['salary_description']; ?></textarea><br><br>
  <input type="submit" name="submit" value="Update Salary">
</form>