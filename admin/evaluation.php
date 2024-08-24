<?php include 'templates/header.php';?>

<?php
include '../db.php';
// Retrieve all evaluations
$sql = "SELECT e.eval_id, e.employee_id, e.eval_value, e.notes, em.employee_name 
        FROM evaluation e 
        JOIN employee em ON e.employee_id = em.employee_id";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display evaluations
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

  button{
    background-color: rgb(255, 213, 0);
    color: #000;
    font-size: 18px;
    padding: 14px 20px;
    font-weight: 600;
    margin: 15px 0;
    border: none;
    cursor: pointer;
    width: 50%;
    transition: background-color 0.10s;
  }
  .cancel-container {
    display: flex;
    align-items: center;
    justify-content:center;
  }
  
.cancelbtn {
    height: 40px;
    align-items: center;
    justify-content: center;
    background-color: red;
    color: #f1f1f1;
    font-size: 16px;
    border-radius: 5px;
    margin-top: 10px;
    margin-left: 300px;
  }
  
.cancelbtn:hover {
    background-color: rgb(157, 0, 0);
  }
</style>

<table>
  <tr>
    <th>Evaluation ID</th>
    <th>Employee Name</th>
    <th>Evaluation Value</th>
    <th>Notes</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) {?>
  <tr>
    <td><?php echo $row['eval_id'];?></td>
    <td><?php echo $row['employee_name'];?></td>
    <td><?php echo $row['eval_value'];?></td>
    <td><?php echo $row['notes'];?></td>
    <td class="actions">
      <a href="edit_evaluation.php?id=<?php echo $row['eval_id'];?>" style="color: green;">Edit</a>
      <a href="delete_evaluation.php?id=<?php echo $row['eval_id'];?>" onclick="return confirm('Are you sure you want to delete this evaluation?')" style="color: red;">Delete</a>
    </td>
  </tr>
  <?php }?>
</table>
<button onclick="location.href='add_eval.php'" class="cancelbtn cancel-container">Add New Evaluation</button> 

<?php include 'templates/footer.php';?>