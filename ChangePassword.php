<?php
//Variables from EditUser.php
$TechID = $_GET['User'];
$Password = $_GET['password'];
//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//Connect to Server
$connect = mysqli_connect($host, $user, $password, $database);
//If unable to connect to server
if(!$connect)
{
    die("Connection Failed");
}
//Update technician's Password in techs database for the Tech
$sql = "UPDATE technicians SET Password = '$Password' WHERE username='$TechID'";
if ($connect->query($sql) === TRUE)
{
    printAlert($TechID."s password has been sucessfully changed");
}
else
{
    echo "Error updating record: " . $connect->error;
}
$connect->close();
//when completed, go to EdutUser.php
header("Location: EditUser.php");
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'EditUser.php';
            </script>";
    die();
}
?>