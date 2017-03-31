<?php
//Variables from TopFive.php
$Top5 = $_GET['Current'];
//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//echo $Top5;
//connection to server
$connect = mysqli_connect($host, $user, $password, $database);
//if unable to connect
if(!$connect)
{
    die("Connection Failed");
}
//Hide selected issue from top five
$sql = "UPDATE topfive SET Selected = FALSE WHERE Issue = '$Top5'";
//echo $Top5;
if ($connect->query($sql) === TRUE)
{
    printAlert($Top5." has been removed from the active issues list");
}
else
{
    echo "Error updating record: " . $connect->error;
}
$connect->close();
header("Location: TopFive.php");
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'TopFive.php';
            </script>";
    die();
}
?>