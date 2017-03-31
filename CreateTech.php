<?php
//Variables from EditUser.php
$FName = $_GET['FName'];
$LName = $_GET['LName'];
$UName = $_GET['username'];
$email = $_GET['email'];
$Pass = $_GET['password'];
$Role = $_GET['Role'];
//Creates Timestam
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$start_date = $date->format("Y-m-d");
//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//Connect to Server
$connect = mysqli_connect($host,$user,$password,$database);
//First name and last name can have capital and lowercase letters, numbers, spaces or hyphins
if (preg_match('/^[a-z-]+$/i', $_GET['FName']) and preg_match('/^[a-z-]+$/i', $_GET['LName'])){
    //username can only have lowercase letters and numbers
    if (preg_match('/^[a-z0-9]+$/i', $_GET['username'])){
        //if unable to connect to server
        if(!$connect) {
            die("Connection Failed");
        }
        //technician is created and sent to technicians table
        $sql = "INSERT INTO techinfo.technicians (username, Password, FName, LName, start_date, e_mail, role)
        VALUES ('$UName', '$Pass', '$FName', '$LName', '$start_date','$email', '$Role')";
        if(mysqli_query($connect,$sql)){
            printAlert($UName." has been created");
        }
        else{
            printAlert($UName." already exists");
        }
        mysqli_close($connect);
        //when completed, go to EdutUser.php
        header("Location: EditUser.php");
    }
    else{
        printAlert("Username must use only lowercase letters and numbers");
    }
}
else{
    printAlert("First name and last name can only have letters and hypens.");
}
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'EditUser.php';
            </script>";
    die();
}
?>