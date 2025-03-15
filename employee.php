<?php
include('../config/db.php');

$results = mysqli_query($conn, "SELECT * FROM employee ORDER BY FirstName ASC  ");
$employee = mysqli_fetch_all($results, MYSQLI_ASSOC);
$empCount = mysqli_num_rows($results);
$count = 1;

if (isset($_POST['add'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $gender = htmlspecialchars($_POST['gender']);
    $phone = htmlspecialchars($_POST['phone']);
    $department = htmlspecialchars($_POST['depart']);
    $dob = htmlspecialchars($_POST['dob']);
    $results = mysqli_query($conn, "INSERT INTO employee VALUES('','$fname','$lname','$gender','$dob','$phone','$department')");
    if ($results) {
        echo "<script>
        alert('employee added successfully')
        window.location.href = window.location.href
        const formCont = document.querySelector('.hide-form-cont')
        formCont.classList.remove('showForm')
        </script>";
    } else {
        echo "<script>
        alert('employee adding failed')
        </script>";
    }
}

if (isset($_POST['del'])) {
    $id = $_POST['id'];
    $results = mysqli_query($conn, "DELETE FROM employee WHERE EmployeeId= '$id'");
    if ($results) {
        echo "<script>
        alert('employee deleted successfully')
        window.location.href = window.location.href
        </script>";
    } else {
        echo "<script>
        alert('employee deletion failed')
        </script>";
    }
}

?>

<?php
if (isset($_POST['search'])) {

    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchitem']);
    $results = mysqli_query($conn, "SELECT * FROM employee 
    WHERE FirstName LIKE '$searchTerm%' OR LastName LIKE '$searchTerm%' 
    OR Gender LIKE '$searchTerm%' OR PhoneNumber LIKE '%$searchTerm%' OR
    Department LIKE '$searchTerm%' 
    ORDER BY FirstName ASC");
    $employee = mysqli_fetch_all($results, MYSQLI_ASSOC);
    $empCount = mysqli_num_rows($results);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../scss/style.css">
    <script src="../script.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #3a3a3a;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #dcdcdc;
        }

        .side-bar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 50px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .side-bar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-bar ul li {
            padding: 15px;
            border-bottom: 1px solid #444;
        }

        .side-bar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .side-bar ul li a i {
            margin-right: 10px;
        }

        .side-bar ul li:hover {
            background-color: #444;
        }

        .body {
            margin-left: 250px;
            padding: 20px;
        }

        .dash-cont {
            margin-bottom: 20px;
        }

        .dash-cont h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .showbtn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .showbtn:hover {
            background-color: #45a049;
        }

        .form-hide-cont {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .form-style {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-style input,
        .form-style select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-style button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            grid-column: span 2;
        }

        .form-style button:hover {
            background-color: #45a049;
        }

        .search-form-cont {
            margin-bottom: 20px;
        }

        .search-form-style input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            margin-right: 10px;
        }

        .search-form-style button {
            background-color: #4caf50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form-style button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        td button,
        td a {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 5px;
            cursor: pointer;
        }

        td button:hover,
        td a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<header>
    <h2>EMPLOYEE <b>ATTENDANCE</b>
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

    <section class="dash-cont">
        <h1>Employee Management</h1>
        <button class="showbtn">Add Employee</button>

        <div class="form-hide-cont">
            <button class="hide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="500" height="500">
                    <path d="M9.15625 6.3125L6.3125 9.15625L22.15625 25L6.21875 40.96875L9.03125 43.78125L25 27.84375L40.9375 43.78125L43.78125 40.9375L27.84375 25L43.6875 9.15625L40.84375 6.3125L25 22.15625Z" />
                </svg>
            </button>
            <h1>Add Employee</h1>
            <form action="" class="form-style" method="post">
                <div>
                    <label for="fname">First Name:</label>
                    <input type="text" required name="fname">
                </div>
                <div>
                    <label for="lname">Last Name:</label>
                    <input type="text" required name="lname">
                </div>
                <div>
                    <label for="gender">Gender:</label>
                    <select name="gender" required>
                        <option selected disabled>Choose your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="dob">Date of Birth:</label>
                    <input type="date" required name="dob">
                </div>
                <div>
                    <label for="phone">Phone Number:</label>
                    <input type="tel" required name="phone">
                </div>
                <div>
                    <label for="department">Department:</label>
                    <input type="text" required name="depart">
                </div>
                <button name="add">Add Employee</button>
            </form>
        </div>

        <div class="search-form-cont">
            <form action="" class="search-form-style" method="post">
                <input type="search" placeholder="Search by name" name="searchitem">
                <button name="search">Search</button>
            </form>
        </div>

        <?php if ($empCount > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employee as $emp) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $emp['FirstName']; ?></td>
                            <td><?php echo $emp['LastName']; ?></td>
                            <td><?php echo $emp['Gender']; ?></td>
                            <td><?php echo $emp['PhoneNumber']; ?></td>
                            <td><?php echo $emp['Department']; ?></td>
                            <td>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" value="<?php echo $emp['EmployeeId']; ?>" name="id">
                                    <button name="del">Delete</button>
                                </form>
                                <a href="edit_employee.php?id=<?php echo $emp['EmployeeId']; ?>">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No employees found.</p>
        <?php } ?>
    </section>
</div>

<script>
    document.querySelector('.showbtn').addEventListener('click', () => {
        document.querySelector('.form-hide-cont').style.display = 'block';
    });

    document.querySelector('.hide').addEventListener('click', () => {
        document.querySelector('.form-hide-cont').style.display = 'none';
    });
</script>

</body>
</html>
