    <!--
    EditUser.php
    -->
<?php
//Variables from EditUser.php
$TechUsername = $_GET['User'];

//server data
$host="localhost";
$user="root";
$password="";
$database="techinfo";

//Creates Timestam
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$end_date = $date->format("Y-m-d");

//connect to server
$connect = mysqli_connect($host, $user, $password, $database);
//if unable to connect to server
if(!$connect)
{
    die("Connection Failed");
}
//update technicians employment status to true
$sql = "UPDATE techinfo.technicians SET end_date = NULL WHERE username = '$TechUsername'";
if ($connect->query($sql) === TRUE)
{
    printAlert($TechUsername." has been re-added as an active technician");
}
else
{
    echo "Error updating record: " . $connect->error;
}
$connect->close();
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