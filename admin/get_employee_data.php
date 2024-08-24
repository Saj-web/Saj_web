<?php include 'templates/header.php'; ?>

<?php
include '../db.php';

// Retrieve all employees
$sql = "SELECT e.employee_id, e.employee_name, e.employee_mobile, e.employee_address, e.employee_email, ur.role
        FROM employee e
        JOIN userroles ur ON e.employee_id = ur.user_id";

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
  $sql .= " WHERE (e.employee_name LIKE '%$search_term%' OR e.employee_mobile LIKE '%$search_term%' OR e.employee_address LIKE '%$search_term%' OR e.employee_email LIKE '%$search_term%')";
} else {
  $sql .= " WHERE 1=1"; // add a dummy WHERE clause to make the query valid
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
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) {?>
  <tr>
    <td><?php echo $row['employee_name'];?></td>
    <td><?php echo $row['employee_mobile'];?></td>
    <td><?php echo $row['employee_address'];?></td>
    <td><?php echo $row['employee_email'];?></td>
    <td><?php echo $row['role'];?></td>
    <td>
      <a href="edit_employee.php?employee_id=<?php echo $row['employee_id'];?>" class="edit">Edit</a>
      <a href="delete_employee_data.php?employee_id=<?php echo $row['employee_id'];?>" class="delete">Delete</a>
    </td>
  </tr>
  <?php }?>
</table>

<?php include 'templates/footer.php';?>