<?php
include 'templates/header.php';
?>

<?php
include '../db.php';
// Retrieve all vacations with employee names
$sql = "SELECT v.vacation_id, e.employee_name, v.vacation_title, v.vacation_from_date, v.vacation_to_date, v.reason
        FROM vacation v
        JOIN employee e ON v.employee_id = e.employee_id";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display vacations
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

  .actions {
    text-align: center;
  }

  .actions a {
    margin: 0 10px;
    color: #337ab7;
    text-decoration: none;
  }

  .actions a:hover {
    color: #23527c;
  }
</style>

<table>
  <tr>
    <th>Employee Name</th>
    <th>Vacation Title</th>
    <th>Vacation From Date</th>
    <th>Vacation To Date</th>
    <th>Reason</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) {?>
  <tr>
    <td><?php echo $row['employee_name'];?></td>
    <td><?php echo $row['vacation_title'];?></td>
    <td><?php echo $row['vacation_from_date'];?></td>
    <td><?php echo $row['vacation_to_date'];?></td>
    <td><?php echo $row['reason'];?></td>
    <td class="actions">
      <a href="edit_vacation.php?id=<?php echo $row['vacation_id']; ?>" style="color: green;">Edit</a>
      <a href="delete_vacation.php?id=<?php echo $row['vacation_id']; ?>" onclick="return confirm('Are you sure you want to delete this vacation?')" style="color: red;">Delete</a>
    </td>
  </tr>

  <?php }?>
</table>

<?php include 'templates/footer.php';?>