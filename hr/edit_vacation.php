
<?php
include '../db.php';
// Retrieve vacation details
$id = $_GET['id'];
$sql = "SELECT v.vacation_id, e.employee_name, v.vacation_title, v.vacation_from_date, v.vacation_to_date, v.reason
        FROM vacation v
        JOIN employee e ON v.employee_id = e.employee_id
        WHERE v.vacation_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Update vacation details
if (isset($_POST['update'])) {
  $vacation_title = $_POST['vacation_title'];
  $vacation_from_date = $_POST['vacation_from_date'];
  $vacation_to_date = $_POST['vacation_to_date'];
  $reason = $_POST['reason'];

  $sql = "UPDATE vacation SET vacation_title = ?, vacation_from_date = ?, vacation_to_date = ?, reason = ?
          WHERE vacation_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssssi", $vacation_title, $vacation_from_date, $vacation_to_date, $reason, $id);
  mysqli_stmt_execute($stmt);

  header("Location: vacation.php");
  exit;
}
?>

<style>
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

  input[type="text"], input[type="date"] {
    width: 100%;
    height: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
  }

  textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
  }

  button[type="submit"] {
    width: 100%;
    height: 40px;
    background-color: #4CAF50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button[type="submit"]:hover {
    background-color: #3e8e41;
  }
</style>

<form action="" method="post">
  <label for="vacation_title">Vacation Title:</label>
  <input type="text" id="vacation_title" name="vacation_title" value="<?php echo $row['vacation_title']; ?>">

  <label for="vacation_from_date">Vacation From Date:</label>
  <input type="date" id="vacation_from_date" name="vacation_from_date" value="<?php echo $row['vacation_from_date']; ?>">

  <label for="vacation_to_date">Vacation To Date:</label>
  <input type="date" id="vacation_to_date" name="vacation_to_date" value="<?php echo $row['vacation_to_date']; ?>">

  <label for="reason">Reason:</label>
  <textarea id="reason" name="reason"><?php echo $row['reason']; ?></textarea>

  <button type="submit" name="update">Update</button>
</form>

<?php include 'templates/footer.php';?>