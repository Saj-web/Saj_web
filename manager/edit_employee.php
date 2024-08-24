<?php
include '../db.php';

$employeeId = $_GET['employee_id'];

// Retrieve employee details
$sql = "SELECT e.employee_id, e.employee_name, e.employee_mobile, e.employee_address, e.employee_email, ur.role
        FROM employee e
        JOIN userroles ur ON e.employee_id = ur.user_id
        WHERE e.employee_id =?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $employeeId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

// Display edit form
?>
<style>
  form {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  table {
    width: 100%;
  }

  th, td {
    padding: 10px;
    text-align: left;
  }

  input[type="text"], input[type="email"], select {
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

<form action="update_employee.php" method="post">
  <input type="hidden" name="employee_id" value="<?php echo $row['employee_id'];?>">
  <table>
    <tr>
      <th>Employee Name:</th>
      <td><input type="text" name="employee_name" value="<?php echo $row['employee_name'];?>"></td>
    </tr>
    <tr>
      <th>Employee Mobile:</th>
      <td><input type="text" name="employee_mobile" value="<?php echo $row['employee_mobile'];?>"></td>
    </tr>
    <tr>
      <th>Employee Address:</th>
      <td><input type="text" name="employee_address" value="<?php echo $row['employee_address'];?>"></td>
    </tr>
    <tr>
      <th>Employee Email:</th>
      <td><input type="email" name="employee_email" value="<?php echo $row['employee_email'];?>"></td>
    </tr>
    <tr>
      <th>Role:</th>
      <td>
      <input type="text" id="role" name="role" value="<?php echo $row['role']; ?>" readonly>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Update Employee"></td>
    </tr>
  </table>
</form>