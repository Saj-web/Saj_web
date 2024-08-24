<?php include 'templates/header.php'; ?>

<?php
include '../db.php';

// Set department ID based on user's role or ID
$departmentId = 0;


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // Retrieve user's department ID from database
    $sql = "SELECT ed.department_id 
            FROM employee e 
            JOIN employee_department ed ON e.employee_id = ed.employee_id 
            WHERE e.employee_id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $departmentId = $row['department_id'];
}

// Retrieve all employees with department_id
$sql = "SELECT e.employee_id, e.employee_name, e.employee_mobile, e.employee_address, e.employee_email, ur.role, d.department_name
        FROM employee e
        JOIN employee_department ed ON e.employee_id = ed.employee_id
        JOIN department d ON ed.department_id = d.department_id
        JOIN userroles ur ON e.employee_id = ur.user_id
        WHERE d.department_id = '$departmentId'";

if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql .= " AND (e.employee_name LIKE '%$search_term%' OR e.employee_mobile LIKE '%$search_term%' OR e.employee_address LIKE '%$search_term%' OR e.employee_email LIKE '%$search_term%')";
}

$sql .= " ORDER BY e.employee_name ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display employees
?>

<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
  }

  th {
    background-color: #f0f0f0;
  }

  .edit {
    color: green;
    text-decoration: none;
  }

  .delete {
    color: red;
    text-decoration: none;
  }
  form {
    text-align: center;
    margin: 20px auto;
  }

  input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 50%;
  }

  button {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button:hover {
    background-color: #3e8e41;
  }
</style>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
  <input type="search" name="search" placeholder="Search employees...">
  <button type="submit">Search</button>
</form>

<table>
  <tr>
    <th>Employee Name</th>
    <th>Employee Mobile</th>
    <th>Employee Address</th>
    <th>Employee Email</th>
    <th>Role</th>
    <th>Department</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) {?>
  <tr>
    <td><?php echo $row['employee_name'];?></td>
    <td><?php echo $row['employee_mobile'];?></td>
    <td><?php echo $row['employee_address'];?></td>
    <td><?php echo $row['employee_email'];?></td>
    <td><?php echo $row['role'];?></td>
    <td><?php echo $row['department_name'];?></td>
    <td>
      <a href="edit_employee.php?employee_id=<?php echo $row['employee_id'];?>" class="edit">Edit</a>
      <a href="delete_employee_data.php?employee_id=<?php echo $row['employee_id'];?>" class="delete">Delete</a>
    </td>
  </tr>
  <?php }?>
</table>

<?php include 'templates/footer.php';?>