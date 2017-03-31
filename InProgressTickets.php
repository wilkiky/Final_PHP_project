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
$i = 0;

$connect = mysqli_connect($host,$user,$password,$database);
if(!$connect)
{
    die("Connection Failed");
}
$sql = mysqli_query($connect,"SELECT * FROM ticket WHERE ticket_stat='IN-PROGRESS' OR ticket_stat='TRANSFERED'");
$num_rows = mysqli_num_rows($sql);
if ($num_rows > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $tech = $row['username'];
        $sql2 = mysqli_query($connect,"SELECT * FROM technicians WHERE username = '$tech'");
        $techdata = mysqli_fetch_assoc($sql2);
        $techfullname = $techdata['FName']." ".$techdata['LName'];
        $i++;
        if ($_SESSION['role'] == 'Viewer'){
            if ($row['ticket_stat'] == "TRANSFERED") {
                echo "<form target='_blank' method='get' action='Student.php'><p align='center'><br>";
                echo $row['FirstName']." ".$row['LastName']." has been transfered to ".$techfullname;
            }
            else{
                echo "<form target='_blank' method='get' action='Student.php'><p align='center'><br>";
                echo $row['FirstName']." ".$row['LastName']." is being helped by ".$techfullname;
            }
        }
        else{
            if ($row['ticket_stat'] == "TRANSFERED") {
                echo "<form target='_blank' method='get' action='Student.php'><p align='center'><br>";
                echo $row['FirstName']." ".$row['LastName']." has been transfered to ".$techfullname
                    ." <input class='submit' type='submit' value='Open' id=submitButton>";
                echo "<input type='hidden' name='IPticketID' value=".$row['ticket_ID']."></form>";
            } else {
                echo "<form target='_blank' method='get' action='Student.php'><p align='center'><br>";
                echo $row['FirstName']." ".$row['LastName']." is being helped by ".$techfullname
                    ." <input class='submit' type='submit' value='Open' id=submitButton>";
                echo "<input type='hidden' name='IPticketID' value=".$row['ticket_ID']."></form>";
            }
        }
    }
}
?>