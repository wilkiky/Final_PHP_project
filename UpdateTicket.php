<?php
session_start();
$TechUsername = $_SESSION['username'];
$Role = $_SESSION['role'];
//Data collected from Student.php
if (isset($_GET['Action']))$Action = $_GET['Action'];
else $Action = null;//Completed, Unresolved, or transfered
if (isset($_GET['RemNUM']))$Remedy = "INC".$_GET['RemNUM'];
else $Remedy = null;//Remedy ticket number
if (isset($_GET['Reason']))$Reason = $_GET['Reason'];
else $Reason = null;//no show, unfixable, or other
if (isset($_GET['Transfer']))$NewTech = $_GET['Transfer'];
else $NewTech = null;//transfered to who
if (isset($_GET['ticketID']))$TicketID = $_GET['ticketID'];
else $TicketID = null;//ticket ID number
//server connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
//Collect current Date
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$timestamp = $date->format("Y-m-d");

    $connect = mysqli_connect($host, $user, $password, $database);
    if(!$connect)
    {
        die("Connection Failed");
    }
    if ($Action != null){
        if ($Action == "COMPLETED") {
            $check = mysqli_query ($connect, "SELECT * FROM ticket WHERE ticket_ID = $TicketID");
            $row = mysqli_fetch_assoc($check);
            $selection = $row['ticket_stat'];
            //if DB has result as completed or unresolved
            if ($selection == "COMPLETED" or $selection == "UNRESOLVED") {
                    printAlert("This ticket has already been completed.");
            }
            $sql = "UPDATE ticket SET ticket_stat = '$Action', Remedy_no = '$Remedy', ticket_stat = 'COMPLETED', username = '$TechUsername' WHERE ticket_ID = $TicketID";
            if ($connect->query($sql) === TRUE){
                $TH = "INSERT INTO ticket_history(Date, Event, ticket_ID, username)
                              VALUES ('$timestamp','Closed', $TicketID, '$TechUsername')";
                if(mysqli_query($connect,$TH)){
                    echo "Two records updated (ticket and ticket history";
                }
                else{
                    echo mysqli_error($connect);
                }
            }
            else{
                echo "Error updating record: " . $connect->error;
            }
        }
        elseif ($Action == "TRANSFERED"){
            $check = mysqli_query ($connect, "SELECT * FROM ticket WHERE ticket_ID = $TicketID");
            $row = mysqli_fetch_assoc($check);
            $selection = $row['ticket_stat'];
            //if DB has result as completed or unresolved
            if ($selection == "COMPLETED" or $selection == "UNRESOLVED") {
                    printAlert("This ticket has already been completed.");
            }
            $sql = "UPDATE ticket SET ticket_stat = '$Action', username = '$NewTech' WHERE ticket_ID = $TicketID";
            if ($connect->query($sql) === TRUE){
                $TH = "INSERT INTO ticket_history(Date, Event, ticket_ID, username, transfered_by)
                              VALUES ('$timestamp','Transfered', $TicketID, '$NewTech', '$TechUsername')";
                if(mysqli_query($connect,$TH)){
                    echo "Two records updated (ticket and ticket history";
                }
                else{
                    echo mysqli_error($connect);
                }
            }
            else{
                echo "Error updating record: " . $connect->error;
            }
        }
        elseif ($Action == "UNRESOLVED"){
            $check = mysqli_query ($connect, "SELECT * FROM ticket WHERE ticket_ID = $TicketID");
            $row = mysqli_fetch_assoc($check);
            $selection = $row['ticket_stat'];
            //if DB has result as completed or unresolved
            if ($selection == "COMPLETED" or $selection == "UNRESOLVED") {
                    printAlert("This ticket has already been completed.");
            }
            $sql = "UPDATE ticket SET ticket_stat = '$Action', reasons = '$Reason' WHERE ticket_ID = $TicketID";
            if ($connect->query($sql) === TRUE){
                $TH = "INSERT INTO ticket_history(Date, Event, ticket_ID, username)
                              VALUES ('$timestamp','Unresolved', $TicketID, '$TechUsername')";
                if(mysqli_query($connect,$TH)){
                    echo "Two records updated (ticket and ticket history";
                }
                else{
                    echo mysqli_error($connect);
                }
            }
            else{
                echo "Error updating record: " . $connect->error;
            }
        }
    }
    $connect->close();
    echo "<script>window.close();</script>";
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.close();
            </script>";
    die();
}

?>