<?php
    include '../db.php';

    if(isset($_POST['submit'])) {
      $employee_name = $_POST['employee_name'];
      $training_type = $_POST['training_type'];
      $training_description = $_POST['training_description'];
  
      // Get the employee ID from the employee table
      $sql = "SELECT employee_id FROM employee WHERE employee_name = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $employee_name);
      $stmt->execute();
      $result = $stmt->get_result();
      $employee_id = $result->fetch_assoc()['employee_id'];

    // Prepare the SQL query
    $sql = "INSERT INTO trainings (employee_id, training_type, training_description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $employee_id, $training_type, $training_description);
    mysqli_stmt_execute($stmt);

    // Get the last inserted ID
    $training_id = mysqli_insert_id($conn);

    // Close the database connection
    mysqli_close($conn);

    // Redirect the user to the training view page
    echo '<script>window.location.href = "training_view.php";</script>';
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

<h1>Add training</h1>

<form action="add_training.php" method="post">
  <label for="employee_name">Employee Name:</label>
  <input type="text" id="employee_name" name="employee_name" required><br><br>
  <label for="training_type">training Type:</label>
  <input type="text" id="training_type" name="training_type" required><br><br>
  <label for="training_description">training Description:</label>
  <textarea id="training_description" name="training_description" required></textarea><br><br>
  <input type="submit" name="submit" value="Add training">
</form>