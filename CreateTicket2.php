
<!--<html>
<body onbeforeunload="return myFunction()">
<p>This example demonstrates how to assign an "onbeforeunload" event to a body element.</p>
<p>Close this window, press F5 or click on the link below to invoke the onbeforeunload event.</p>
<a href="http://www.w3schools.com">Click here to go to w3schools.com</a>
<script>
    function myFunction() {
        return "Write something clever here...";
    }
</script>

-->
<?php
//Variables from CustomerLogin.php
$FName = $_GET['firstname'];
$LName = $_GET['lastname'];
$SSO = $_GET['ssoid'];
$User = $_GET['User'];
$Issue = $_GET['Current'];
$Other = $_GET['issue'];

echo  $FName, $LName, $SSO, $User, $Issue, $Other;

//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";

//Creates Timestam
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$start_date = $date->format("Y-m-d");


//Connect to Server
$connect = mysqli_connect($host,$user,$password,$database);
//If unable to connect to server
if(!$connect)
{
    die("Connection Failed");
}
//Update customers's data in ticket database
$sql = "INSERT INTO techinfo.ticket ( FirstName, LastName, UserType, SSOID , Issue, Other, ticket_stat)
            VALUES ('$FName','$LName','$User','$SSO','$Issue','$Other','NEW')";
if(mysqli_query($connect,$sql))
{
    echo mysqli_insert_id($connect);
//    $tickethistory = "INSERT INTO ticket_history( Date, Event, ticket_ID) VALUES ('$current_date', 'Created', )";
}
else
{
//    echo mysqli_error($connect);
}
mysqli_close($connect);
//when completed, go to CustomerLogin.php
//header("Location: CustomerLogin.php");
?>
<?php/*
    // Attempting to add Event to Ticket History table but it now throws an error or Undefined Index for top queue.
    $defaultTimeZone = new DateTimeZone("America/Chicago");
    $date = new DateTime("now", $defaultTimeZone);
    $start_date = $date->format("Y-m-d");


    $connect = mysqli_connect($host,$user,$password,$database);
    //Update ticket history for newly created ticket
    $max = "Select MAX(ticket_ID) FROM ticket";
    $sql= "INSERT INTO ticket_history(Date, Event, ticket_ID)
        VALUES ($start_date,'Created', ticket.ticketID where ticket_ID = $max)";
    if(mysqli_query($connect,$sql))
    {
        echo "New record created";
    }
    else
    {
        echo mysqli_error($connect);
    }
    mysqli_close($connect);
//when completed, go to CustomerLogin.php
//header("Location: CustomerLogin.php");*/
?>
