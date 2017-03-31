<?php
    //Variables from EditUser.php
    session_start();
//tech from dropdown box
$TechUsername = $_GET['User'];
//tech making changes
$Tech = $_SESSION['username'];
    //server information
    $host="localhost";
    $user="root";
    $password="";
    $database="techinfo";
    //Creates Timestam
    $defaultTimeZone = new DateTimeZone("America/Chicago");
    $date = new DateTime("now", $defaultTimeZone);
    $end_date = $date->format("Y-m-d");
    //Connection to server
    $connect = mysqli_connect($host, $user, $password, $database);
    //if unable to connect to the server
    if(!$connect){
        die("Connection Failed");
    }
    //Update technician's status (employment) techs database
    $sql = mysqli_query($connect, "SELECT role FROM technicians WHERE username = '$TechUsername'");
    $row = mysqli_fetch_assoc($sql);
    //assigns tech to be deleted's role to $TechRole
    $TechRole = $row['role'];
    if ($TechRole == 'Admin'){
        //Checks to see if this is the only admin.  If so, the admin cannot be deleted and redirect to EditUser.php
        $sql = mysqli_query($connect, "SELECT * FROM technicians WHERE role= 'Admin' AND end_date IS NULL AND username != '$TechUsername'");
        $num_rows = mysqli_num_rows($sql);
        if ($num_rows < 2){
            printAlert("Must have two active Admins. Please make another Technician an Administrator before deleting ".$TechUsername);
        }
    }
    //delete technician
    if ($TechUsername != $_SESSION['username']){
        $sql = "UPDATE techinfo.technicians SET end_date = '$end_date' WHERE username = '$TechUsername'";
        if ($connect->query($sql) === TRUE) {
            printAlert("You have successfully deleted ".$TechUsername);
        } else {
            echo "Error updating record: " . $connect->error;
        }
        $connect->close();
        header("Location: EditUser.php");
    }
    else{
        printAlert("You cannot delete yourself");
    }
    header("Location: EditUser.php");
function printAlert($text){
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'EditUser.php';
            </script>";
    die();
}
?>