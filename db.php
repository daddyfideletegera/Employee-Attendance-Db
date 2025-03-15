<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employeeattendancedb";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if($conn){
    // echo"Database Connected";
}  else {
    die("Not Connected").mysqli_error($conn);
}
 ?>