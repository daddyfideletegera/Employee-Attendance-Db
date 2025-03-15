<?php 
include('../config/db.php');
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO admin (AdminName,Password) values ('$username','$password')";
    $runsql = mysqli_query($conn,$sql);

    if($runsql){
        echo "<script>alert('Registered Successful'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Unsuccessful registration'); window.location.href='register.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/all.css">
    
</head>
<body>
    <div class="form">
        <form action="register.php" method="POST">
            <div class="input">
                <p>EMPLOYEE ATTENDANCE DATABASE </p>
            </div>
        
            <div class="input">
                <label for="">UserName:</label><br>
                <input type="text" name="username" required>                
            </div>
            <div class="input">
                <label for="">Password:</label><br>
                <input type="password" name="password" required>
            </div>
            <div class="input">
                <button type="submit" name="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>