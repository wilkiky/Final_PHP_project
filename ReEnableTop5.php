    <!--
    TopFive.php
    -->

<?php
//Variables from TopFive.php
$Top5 = $_GET['Old'];

//server data
$host="localhost";
$user="root";
$password="";
$database="techinfo";

//connect to server
$connect = mysqli_connect($host, $user, $password, $database);
//if unable to connect to server, end
if(!$connect)
{
    die("Connection Failed");
}
//select all active issues from topfive database
$result = mysqli_query($connect,"SELECT * FROM topfive WHERE Selected = TRUE ");
//how many active issues in topfive database
$rowcount = mysqli_num_rows($result);
//if there are five active issues, no more can be added until one is dropped
if($rowcount>4){
    printAlert("You will have to remove an issue from Current Issues first");
}
//and issue to active issues
$sql = "UPDATE techinfo.topfive SET Selected = True WHERE Issue = '$Top5'";
if ($connect->query($sql) === TRUE)
{
    printAlert($Top5." has been added to active issues dropdown");
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