<?php
include '../db.php';

$sql = "SELECT e.employee_name, v.vacation_id, v.vacation_title, v.vacation_from_date, v.vacation_to_date, v.reason, v.status
FROM employee e
JOIN vacation v ON e.employee_id = v.employee_id
WHERE v.status = 'Pending'";
$stmt = mysqli_prepare($conn, $sql);
if (!mysqli_stmt_execute($stmt)) {
    echo "Error executing query: " . mysqli_stmt_error($stmt);
}
$result = mysqli_stmt_get_result($stmt);

$vacations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $vacations[] = $row;
}

if (empty($vacations)) {
    echo "No vacation requests found!";
}


?>

<?php include 'templates/header.php';?>
<div class="d-flex">
    <?php include 'templates/aside.php';?>
    <div class="content mt-3">
        <div class="container p-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h2 class="text-center display-6 mb-4">Employee Vacation</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Reasons</th>
                                        <th>Status</th>
                                        <th>Accept</th>
                                        <th>Reject</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($vacations as $vacation):?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($vacation['vacation_id']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['employee_name']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['vacation_title']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['vacation_from_date']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['vacation_to_date']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['reason']);?></td>
                                        <td><?php echo htmlspecialchars($vacation['status']);?></td>
                                        <?php if (htmlspecialchars($vacation['status']) =='Pending'):?>
                                            <form method="post" action="update_vacation_status.php">
                                                <input type="hidden" name="vacation_id" value="<?php echo htmlspecialchars($vacation['vacation_id']);?>">
                                                <input type="hidden" name="status" value="accepted">
                                                <td><button type="submit" class="btn btn-primary">Accept</button></td>
                                            </form>
                                            <form method="post" action="update_vacation_status.php">
                                                <input type="hidden" name="vacation_id" value="<?php echo htmlspecialchars($vacation['vacation_id']);?>">
                                                <input type="hidden" name="status" value="rejected">
                                                <td><button type="submit" class="btn btn-danger">Reject</button></td>
                                            </form>
                                        <?php endif;?>
                                    </tr>
                <?php endforeach;?>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>