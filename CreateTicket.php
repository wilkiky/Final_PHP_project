<?php
//Variables from CustomerLogin.php
$FName = $_GET['firstname'];
$LName = $_GET['lastname'];
$SSO = $_GET['ssoid'];
$User = $_GET['User'];
$Issue = $_GET['Current'];
$Other = $_GET['issue'];
//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//Collect current Date
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$timestamp = $date->format("Y-m-d");
//Connect to Server


$connect = mysqli_connect($host,$user,$password,$database);
//First name and last name can have capital and lowercase letters, numbers, spaces or hyphins
//if (preg_match("/^[A-Za-z -]+$/*", $_GET['firstname']) and preg_match("/^[A-Za-z -]+$/", $_GET['lastname'])) {
if (preg_match('/^[a-z-]+$/i', $_GET['firstname']) and preg_match('/^[a-z-]+$/i', $_GET['lastname'])) {
    //username can only have lowercase letters and numbers
    /// we took this out Kyle because it broke and wouldn't accept a submit w/ a blank SSOID
//    if (preg_match('/^[a-z0-9]+$/i', $_GET['ssoid'])) {


    //If unable to connect to server
    if (!$connect) {
        die("Connection Failed");
    }
    //Update customers's data in ticket database

    $sql = "INSERT INTO ticket ( FirstName, LastName, UserType, SSOID , Issue, Other, ticket_stat) VALUES ('$FName','$LName','$User','$SSO','$Issue','$Other','NEW')";
    if (mysqli_query($connect, $sql)) {
        //assigns ticket ID from last record created to $newTicketId
        $newTicketID = mysqli_insert_id($connect);
        $TH = "INSERT INTO ticket_history(Date, Event, ticket_ID) VALUES ('$timestamp','Created', '$newTicketID')";


        if (mysqli_query($connect, $TH)) {
            printAlert("You have been placed in the queue. Someone will be with you shortly.");
        } else {
            printAlert("Ticket history was not updated.");
        }
    }
    else {
        printAlert("You have NOT been added in the queue. Please try again.");
    }
}
   // else {
    //    printAlert("SSO ID can only be lowercase letters and numbers.");
  //  }
//}
else {
    printAlert("First name and last name can only have letters and hypens.");
}
mysqli_close($connect);
//when completed, go to CustomerLogin.php
header("Location: CustomerLogin.php");
function printAlert($text){
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'CustomerLogin.php';
            </script>";
    die();
}
?>