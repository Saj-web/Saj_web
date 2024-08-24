<?php include 'templates/header.php'; ?>
<?php

// Connect to the database
include '../db.php';

// Query to retrieve attendance information
$sql = "SELECT e.employee_name, e.employee_mobile, a.attendance_date, a.attendance_status
        FROM attendance a
        JOIN employee e ON a.employee_id = e.employee_id
        ORDER BY a.attendance_date DESC";

$result = mysqli_query($conn, $sql);

?>

<style>
  table {
    border-collapse: collapse;
    width: 100%;
    font-family: Arial, sans-serif;
  }


  th {
    background-color:#004c9d;
    color: #fff;
    padding: 10px;
    text-align: left;
    border-bottom: 2px solid #ddd;
  }

 
  td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }


  tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  tr:hover {
    background-color: #ddd;
  }

 
  table {
    margin: 20px;
  }
</style>

<?php
if (mysqli_num_rows($result) > 0) {
    // Display attendance information
    echo "<table>";
    echo "<tr>";
    echo "<th>Employee Name</th>";
    echo "<th>Employee Mobile</th>";
    echo "<th>Attendance Date</th>";
    echo "<th>Attendance Status</th>";
    echo "</tr>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["employee_name"] . "</td>";
        echo "<td>" . $row["employee_mobile"] . "</td>";
        echo "<td>" . $row["attendance_date"] . "</td>";
        echo "<td>" . $row["attendance_status"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No attendance records found.";
}

// Close connection
mysqli_close($conn);
?>
