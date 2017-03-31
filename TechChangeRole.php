<?php
session_start();
//Variables from EditUser.php
//tech from dropdown box
$TechUsername = $_GET['User'];
//tech making changes
$Tech = $_SESSION['username'];
$Role = $_GET['Role'];
//database info
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//connect to server
$connect = mysqli_connect($host, $user, $password, $database);
if(!$connect) {
    die("Connection Failed");
}
//Cannot change you own roles
if ($TechUsername == $Tech){
    printAlert("You cannot change your own role.");
}
$sql = mysqli_query($connect, "SELECT role FROM technicians WHERE username <> '$TechUsername'");
$row = mysqli_fetch_assoc($sql);
//assigns tech to be deleted's role to $TechRole
$TechRole = $row['role'];
if ($TechRole == 'Admin') {
    //Checks to see if there are only two admin.  If so, the admin cannot be deleted and redirect to EditUser.php
    $sql = mysqli_query($connect, "SELECT * FROM technicians WHERE role= 'Admin' AND end_date IS NULL");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows < 2){
        printAlert("Must have two active Admins. Please make another Technician an Administrator before deleting ".$TechUsername);
    }
}
if ($TechUsername != $_SESSION['username']) {
    $sql = "UPDATE technicians SET Role = '$Role' WHERE username = '$TechUsername'";
    if ($connect->query($sql) === TRUE) {
        printAlert($TechUsername . "s role has been changed to " . $Role);
    } else {
        echo "Error updating record: " . $connect->error;
    }
    $connect->close();
    header("Location: EditUser.php");
}
else{
    printAlert("You cannot change your own role");
}
function printAlert($text){
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'EditUser.php';
            </script>";
    die();
}
?>