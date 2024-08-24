<?php
include '../db.php';

if (isset($_GET['id'])) {
  $training_id = $_GET['id'];
  $sql = "SELECT * FROM trainings WHERE training_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $training_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if (isset($_POST['submit'])) {
    $employee_id = $_POST['employee_id'];
    $training_type = $_POST['training_type'];
    $training_description = $_POST['training_description'];

    $sql = "UPDATE trainings SET employee_id = ?, training_type = ?, training_description = ? WHERE training_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issi", $employee_id, $training_type, $training_description, $training_id);
    mysqli_stmt_execute($stmt);

    header("Location: training_view.php");
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

<h1>Edit training</h1>

<form action="edit_training.php?id=<?php echo $training_id; ?>" method="post">
  <label for="employee_id">Employee ID:</label>
  <input type="text" id="employee_id" name="employee_id" value="<?php echo $row['employee_id']; ?>"><br><br>
  <label for="training_type">training Type:</label>
  <input type="text" id="training_type" name="training_type" value="<?php echo $row['training_type']; ?>"><br><br>
  <label for="training_description">training Description:</label>
  <textarea id="training_description" name="training_description"><?php echo $row['training_description']; ?></textarea><br><br>
  <input type="submit" name="submit" value="Update training">
</form>