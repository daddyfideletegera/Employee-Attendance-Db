<?php
include('../config/db.php');

$date = date('Y-m-d');
$results = mysqli_query($conn, "SELECT * FROM employee ORDER BY FirstName ASC ");
$employees = mysqli_fetch_all($results, MYSQLI_ASSOC);
$count = 1;

$run_attendance_query = mysqli_query($conn, "SELECT * FROM employee INNER JOIN attendance ON employee.EmployeeId = attendance.EmployeeId");
$attendances = mysqli_fetch_all($run_attendance_query, MYSQLI_ASSOC);
$attendCount = mysqli_num_rows($run_attendance_query);

if (isset($_POST['add'])) {
    $empId = htmlspecialchars($_POST['empId']);
    $checkInTime = htmlspecialchars($_POST['checktime']);
    $status = htmlspecialchars($_POST['status']);
    $date = date('Y-m-d');
    $results = mysqli_query($conn, "INSERT INTO attendance VALUES('', '$empId', '$date', '$checkInTime', '', '$status')");
    if ($results) {
        echo "<script>alert('Attendance added successfully'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Attendance adding failed');</script>";
    }
}

if (isset($_POST['del'])) {
    $id = $_POST['id'];
    $results = mysqli_query($conn, "DELETE FROM attendance WHERE AttendanceId= '$id'");
    if ($results) {
        echo "<script>alert('Attendance deleted successfully'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Attendance deletion failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat-box {
            padding: 20px;
            width: 22%;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            color: white;
            font-weight: bold;
        }
        .stat-box.present { background: #4caf50; }
        .stat-box.late { background: #ff9800; }
        .stat-box.absent { background: #f44336; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #333;
            color: #fff;
        }
    </style>
</head>
<body>

<header class="header">
    <h2 class="u-name">EMPLOYEE <b>ATTENDANCE</b>
        <label for="checkbox">
            <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
        </label>
    </h2>
    <h3>Welcome, <?php echo isset($_SESSION['AdminName']) ? $_SESSION['AdminName'] : 'Admin'; ?></h3>
    <i class="fa fa-user" aria-hidden="true"></i>
</header>

<div class="body">
    <nav class="side-bar">
        <ul>
            <li><a href="dash.php"><i class="fa fa-desktop"></i><span>Dashboard</span></a></li>
            <li><a href="employee.php"><i class="fa fa-users"></i><span>Employee</span></a></li>
            <li><a href="attendance.php"><i class="fa fa-calendar"></i><span>Attendance</span></a></li>
            <li><a href="../auth/logout.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
        </ul>
    </nav>

    <section class="section-1">
        <div class="container">
            <h2>Attendance Records</h2>
            
            <!-- Attendance Form -->
            <form method="POST" action="">
                <label for="empId">Employee:</label>
                <select name="empId" required>
                    <option value="" disabled selected>Select Employee</option>
                    <?php foreach ($employees as $emp) : ?>
                        <option value="<?= $emp['EmployeeId'] ?>"><?= $emp['FirstName'] . ' ' . $emp['LastName'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label for="checktime">Check-in Time:</label>
                <input type="time" name="checktime" required>

                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Present">Present</option>
                    <option value="Late">Late</option>
                    <option value="Absent">Absent</option>
                </select>

                <button type="submit" name="add">Add Attendance</button>
            </form>

            <!-- Attendance Table -->
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Check-in Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendances as $index => $att) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $att['FirstName'] . ' ' . $att['LastName'] ?></td>
                            <td><?= $att['Date'] ?></td>
                            <td><?= $att['CheckInTime'] ?></td>
                            <td><?= $att['Status'] ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $att['AttendanceId'] ?>">
                                    <button type="submit" name="del" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>
