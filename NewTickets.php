<?php
session_start();
if ($_SESSION['role']!='StaffTech')
{
    if ($_SESSION['role']!='StudentTech')
    {
        if ($_SESSION['role'] !='Admin')
        {
            if ($_SESSION['role'] !='Viewer')
            {
                header("Location: index.php");
            }
        }
    }
}

$host="localhost";
$user="root";
$password="";
$database="techinfo";

$connect = mysqli_connect($host,$user,$password,$database);
if(!$connect)
{
    die("Connection Failed");
}
$sql = mysqli_query($connect,"SELECT * FROM ticket WHERE ticket_stat = 'NEW'");
$num_rows = mysqli_num_rows($sql);
if ($num_rows > 0)
{
    while ($row = mysqli_fetch_assoc($sql))
    {
        echo "<p align='center'>". $row['FirstName']." ".$row['LastName']."<br></p>";
    }
}
?>
