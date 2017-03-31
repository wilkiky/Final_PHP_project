<?php
session_start();
if ($_SESSION['role']!='StaffTech') {
    if ($_SESSION['role']!='StudentTech') {
        if ($_SESSION['role'] !='Admin') {
            header("Location: index.php");
        }
    }
}
//Database Access
$host="localhost";
$user="root";
$password="";
$database="techinfo";
$selection = "";
//Collect current Date
$defaultTimeZone = new DateTimeZone("America/Chicago");
$date = new DateTime("now", $defaultTimeZone);
$timestamp = $date->format("Y-m-d");
if (isset($_GET['IPticketID']))$INP = $_GET['IPticketID'];
else $INP = null;
$Technician = $_SESSION['username'];
?>

<html>
    <link rel="stylesheet" type="text/css" href="StudentCSS.css">
    <link rel="stylesheet" type="text/css" href="CP.css">
    <link rel="stylesheet" type="text/css" href="HelpButton.css">
    <head><title>Application</title></head>
    <script type="text/javascript">
        document.getElementById('StudentForm').submit(function()
        {
            window.onbeforeunload = null
            window.close;
        });
        function init()
        {
            actionBox = document.getElementById('ActionDD');
            reasonBox = document.getElementById('ReasonDD');
            transferBox = document.getElementById('TransferDD');
            completeBox = document.getElementById('COMPLETEbox');
            remTextBox = document.getElementById('REMtextBox');
            selectedAction = actionBox.value;
            remTextBox.style.display = 'none';
            remTextBox.removeAttribute("required");
            reasonBox.style.display = 'none';
            reasonBox.removeAttribute("required");
            transferBox.style.display = 'none';
            transferBox.removeAttribute("required");
            isFormValid = false;
        }
        function showHide()
        {
            init();
            if (selectedAction == 'COMPLETED')
            {
                remTextBox.style.display = 'inline-block';
                remTextBox.setAttribute("required", "required");
            }
            else if (selectedAction == 'UNRESOLVED')
            {
                reasonBox.style.display = 'inline-block';
                reasonBox.setAttribute("required", "required");
            }
            else if (selectedAction == 'TRANSFERED')
            {
                transferBox.style.display = 'inline-block';
                transferBox.setAttribute("required", "required");
            }
        }
    </script>
    <body>
        <h1><center>Current Customer Application</center></h1>
        <div id="helpPOPUP" class="overlay">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    This is the Current Customer Application. This can also be referred to as the customers ‘Ticket’
                    <br><br>
                    What can be seen on this page is the customers: <br>
                    <b>Customer’s First and Last Name</b> <br>
                    <b>Customer’s SSO ID</b> <br>
                    <b>Customer Problem</b> <br>
                    <b>Customer’s User Type</b> <br><br>
                    If the customer’s problem is listed as ‘Other’ then another field pop’s up that lists ‘Details’ of the problem. <br><br>
                    The function of this page is to give the tech information about the customer. Then when the tech is complete helping the customer the tech will then mark an ‘Action’ for the ticket. There are three different ticket completions. <br>
                    Completed, Transferred, and Unresolved <br><br>
                    If <b>Completed</b> is selected, then a Remedy Number is then required. Please only enter the numeric Remedy Number. <br><br>
                    If <b>Transferred</b> is selected, then a new tech must be selected to take on the current ticket. <br><br>
                    If <b>Unresolved</b> is selected, then a reason needs to be selected: <br><br>
                    Customer No Show – would be selected if the tech goes to call on the customer and they are no longer waiting in the TSC. <br><br>
                    Non-IT Issue – would be selected if the tech cannot solve the issue because it is out of the scope of the TSC’s job. <br><br>
                    Personal Hardware Issue – would be selected if the tech cannot solve the issue because there is a hardware problem with the customer’s device. <br><br>
                    After a selection is made then press ‘Submit’ to close the ticket.
                </div>
            </div>
        </div>
        <div id="Student">
            <table>
                <tbody>
                    <?php
                    $connect = mysqli_connect($host, $user, $password, $database);
                    $sql = null;
                    if(!$connect)
                    {
                        die("Connection Failed");
                    }
                    //directed here from either Queue.php or AdminPanel.php
                    if ($INP == null)
                    {
                        //selecting next student from NEW
                        $sql = mysqli_query($connect, "SELECT * FROM ticket WHERE ticket_stat = 'New' ORDER BY ticket_ID  ASC LIMIT 1");
                    }
                    //redirected here from UpdateTicket.php
                    elseif ($INP != null)
                    {
                        $check = mysqli_query($connect, "SELECT * FROM ticket WHERE ticket_ID = '$INP'");
                        $row = mysqli_fetch_assoc($check);
                        $selection = $row['ticket_stat'];
                        if ($selection == "COMPLETED")
                        {
//                            die(header("Location: Errors.php?error=".urlencode("1")));
                        }
                        $sql = mysqli_query($connect, "SELECT * FROM ticket WHERE ticket_ID = '$INP'");
                    }
                    $row = mysqli_fetch_assoc($sql);
                    $selection = $row['ticket_ID'];
                    //add to ticket history
                    $TH = "INSERT INTO ticket_history(Date, Event, ticket_ID, username)
                          VALUES ('$timestamp','In-Progress', '$selection', '$Technician')";
                    if(mysqli_query($connect,$TH))
                    {

                    }
                    else
                    {
                        echo mysqli_error($connect);
                    }
                    $connect->close();
                    echo "<p align='center'><br>" . $row['FirstName'] . " " . $row['LastName'] . "</p>";
                    echo "<p align='center'>SSO ID: " . $row['SSOID'] . "</p>";
                    echo "<p align='center'>User Type: ".$row['UserType']."</p>";
                    echo "<p align='center'>Problem: " . $row['Issue'] . "</p>";
                    if($row['Other']!="")
                    {
                        echo "<p align='center'>Details: " . $row['Other'] . "</p>";
                    }
                    $connect = mysqli_connect($host, $user, $password, $database);
                    if (!$connect)
                    {
                        die("Connection Failed");
                    }
                    $Tech = $_SESSION['username'];
                    $sql = "UPDATE ticket SET username = '$Tech', ticket_stat = 'IN-PROGRESS'  WHERE ticket_ID = '$selection'";
                    if ($connect->query($sql) === TRUE) {
                    }
                    else
                    {

                    }
                    $connect->close();
                    ?>
                </tbody>
            </table>
        </div>
        <form method="get" action="UpdateTicket.php" name=StudentForm id="StudentForm">
            <div class="DDbox">
                <select name="Action" id="ActionDD" required onchange="showHide()">
                    <?php
                    $connect=mysqli_connect($host, $user, $password, $database);
                    $sql = mysqli_query($connect,"SELECT * FROM ticket_status WHERE ticket_stat='COMPLETED' OR ticket_stat='UNRESOLVED' OR ticket_stat='TRANSFERED'");
                    echo "<option value=''>Action</option>";
                    while ($row = mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$row['ticket_stat']."'>".$row['ticket_stat']."</option>";
                    }
                    echo "</select>";
                    ?>
                </select>
            </div><br>
            <div class="COMPLETEbox" id="COMPLETEbox" >
                <input class="hidden-items" type="number" name="RemNUM" id="REMtextBox" placeholder="Remedy Number" min="1" maxlength="10" style="display:none;"/><br>
                <select class="hidden-items" name="Reason" id="ReasonDD" style="display:none;">
                    <option value="">Reason:</option>
                    <?php
                    $connect=mysqli_connect($host, $user, $password, $database);
                    $sql = mysqli_query($connect,
                        "SELECT * FROM abandon_reasons");
//                    echo "<option value=''>Action</option>";
                    while ($row = mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$row['reasons']."'>".$row['reasons']."</option>";
                    }
                    echo "</select>";
                    ?>
                </select>
                <!--Pulls available technicians from the technicians table-->
                <select class="hidden-items" name="Transfer" id="TransferDD" style="display:none;">
                    <option value="">Person:</option>
                    <?php
                    $connect=mysqli_connect($host, $user, $password, $database);
                    $sql = mysqli_query($connect, "SELECT * FROM technicians where end_date IS NULL and role != 'Viewer'");
                    while ($row = mysqli_fetch_array($sql))
                    {
                        echo "<option value='".$row['username']."'>".$row['username']."</option>";
                    }
                    echo "</select><br><br>";
                    ?>
                <input class="submit" type="submit" value="Submit" id=submitButton>
                    <br><br><br>
                    <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
                    <input type="hidden" name="ticketID" value="<?php echo $selection; ?>">
            </div>
        </form>
    </body>
</html>