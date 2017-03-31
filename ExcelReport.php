<?php
$TC = 0;
$TA = 0;
$OT = 0;
$TPS = 0;
$UT = 0;
$DC = 0;
$OTS = 0;
$TD = 0;
$TCoutput = 0;
$TAoutput = 0;
$TPSoutput = 0;
$OToutput = 0;
$UToutput = 0;
$DCoutput = 0;
$TDoutput = 0;

$StartDate = $_POST['beginDate'];
$EndDate = $_POST['endDate'];
$host = "localhost";
$user = "root";
$password = "";
$database = "techinfo";
$StartDate = datavalidation($StartDate);
$EndDate = datavalidation($EndDate);

//if end date is before start date
if($EndDate < $StartDate){
    printAlert("End date cannot be before start date");
}
if(isset($_POST['submit'])){
    if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
        $checked_count = count($_POST['check_list']);
// Loop to store and display values of individual checked checkbox.
        foreach($_POST['check_list'] as $selected) {
            if ($selected == "total_customers"){
                $TC = 1;
            }
            if ($selected == "incident_tracking"){
                $TA = 1;
            }
            if ($selected == "overdue_tickets"){
                $OT = 1;
            }
            if ($selected == 'tech_performance_summary'){
                $TPS = 1;
            }
            if ($selected == 'unresolved_tickets'){
                $UT = 1;
            }
            if ($selected == 'duplicate_customers'){
                $DC = 1;
            }
            if ($selected == 'multiple_transfers'){
                $TD = 1;
            }
        }
    }
    else{
        echo "You did not make a valid select please choose again";
        header("Location: Reports.php");
    }
}
if ($TC == 1) {
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
        "SELECT * FROM total_customers
          WHERE ticket_stat = 'COMPLETED'
          AND Date BETWEEN '$StartDate' AND '$EndDate'
          ORDER BY ticket_ID");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $TCoutput = "<table class = 'table' bordered = '1'>
                    <tr>
                        <th>Ticket #</th>
                        <th>Technician</th>
                        <th>Remedy #</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>SSO ID</th>
                        <th>User Type</th>
                        <th>Issue</th>
                        <th>Other</th>
                        <th>Date</th>
                    </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {
            $TCoutput .= "<tr>
                        <td>" . $data['ticket_ID'] . "</td>
                        <td>" . $data['username'] . "</td>
                        <td>" . $data['Remedy_no'] . "</td>
                        <td>" . $data['LastName'] . "</td>
                        <td>" . $data['FirstName'] . "</td>
                        <td>" . $data['SSOID'] . "</td>
                        <td>" . $data['UserType'] . "</td>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['Other'] . "</td>
                        <td>" . $data['Date'] . "</td>
                    </tr>";
        }
        $TCoutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=TotalCustomers.xls");
        echo $TCoutput;
    }
    else{
       printAlert("There are no completed tickets at this time for this date range.");
    }


}

if ($TA == 1) {
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
        "SELECT * FROM incident_tracking");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $TAoutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>Issue</th>
                        <th>Other</th>
                        <th>Incidents</th>
                    </tr>';
        while ($data = mysqli_fetch_assoc($sql)) {
            $TAoutput .= "<tr>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['Other'] . "</td>
                        <td>" . $data['Incidents'] . "</td>
                    </tr>";
        }
        $TAoutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=IncidentTracking.xls");
        echo $TAoutput;
    }
    else{
        printAlert("There are no incidents to track at this time.");
    }
}
if ($OT == 1)
    {
        $i = 0;
        $connect = mysqli_connect($host, $user, $password, $database);
        $sql = mysqli_query($connect,
            "SELECT * FROM tickets_over24 where Date BETWEEN '$StartDate' and '$EndDate'  ");
        $num_rows = mysqli_num_rows($sql);
        if ($num_rows > 0) {
            $OToutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>ticket_ID</th>
                        <th>username</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>UserType</th>
                        <th>Issue</th>
                        <th>ticket_stat</th>
                        <th>reasons</th>
                        <th>transferred_by</th>
                        <th>Creation Date</th>
                        <th>Work_Days</th>
                    </tr>';
            while ($data = mysqli_fetch_assoc($sql)) {
                $OToutput .= "<tr>
                        <td>" . $data['ticket_ID'] . "</td>
                        <td>" . $data['username'] . "</td>
                        <td>" . $data['FirstName'] . "</td>
                        <td>" . $data['LastName'] . "</td>
                        <td>" . $data['UserType'] . "</td>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['ticket_stat'] . "</td>
                        <td>" . $data['reasons'] . "</td>
                        <td>" . $data['transfered_by'] . "</td>
                        <td>" . $data['Date'] . "</td>
                        <td>" . $data['WORK_DAYS'] . "</td>
                    </tr>";
            }
            $OToutput .= "</table>";
            header("Content-Type: appliction/xls");
            header("Content-Disposition: attachment; filename=ticketsOver24.xls");
            echo $OToutput;
        }
        else{
            printAlert("There are tickets that have been in the system for over 24-hours at this time.");
        }
}
    if ($TPS == 1)
    {
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
        "SELECT * FROM tech_performance_summary");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $TPSoutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>username</th>
                        <th>FName</th>
                        <th>LName</th>
                        <th>role</th>
                        <th>ticket_stat</th>
                        <th>Tickets_Worked</th>
                        <th>PERCENT</th>
                    </tr>';
        while ($data = mysqli_fetch_assoc($sql)) {
            $TPSoutput .= "<tr>
                        <td>" . $data['username'] . "</td>
                        <td>" . $data['FName'] . "</td>
                        <td>" . $data['LName'] . "</td>
                        <td>" . $data['role'] . "</td>
                        <td>" . $data['ticket_stat'] . "</td>
                        <td>" . $data['Tickets_WORKED'] . "</td>
                        <td>" . $data['PERCENT'] . "</td>
                    </tr>";
        }
        $TPSoutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=TechPerformanceSummary.xls");
        echo $TPSoutput;
    }
    else{
        printAlert("There have been no completed tickets at this time.");
    }
}

if ($UT == 1)
{
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
       "SELECT * FROM unresolved_tickets where DATE BETWEEN '$StartDate' and '$EndDate'ORDER BY DATE");

    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $UToutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>username</th>
                        <th>FName</th>
                        <th>LName</th>
                        <th>role</th>
                        <th>ticket_stat</th>
                        <th>Issue</th>
                        <th>Other</th>
                        <th>DATE</th>
                    </tr>';
        while ($data = mysqli_fetch_assoc($sql)) {
            $UToutput .= "<tr>
                        <td>" . $data['username'] . "</td>
                        <td>" . $data['FName'] . "</td>
                        <td>" . $data['LName'] . "</td>
                        <td>" . $data['role'] . "</td>
                        <td>" . $data['ticket_stat'] . "</td>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['Other'] . "</td>
                        <td>" . $data['DATE'] . "</td>
                    </tr>";
        }
        $UToutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=UnresolvedTickets.xls");
        echo $UToutput;
    }
    else{
        printAlert("There are no unresolved tickets at this time.");
    }
}

if ($DC == 1)
{
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
        "SELECT * FROM duplicate_customers ");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $DCoutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>UserType</th>
                        <th>Issue</th>
                        <th>Other</th>
                        <th>ticket_stat</th>
                        <th>reasons</th>
                        <th>Visits</th>
                    </tr>';
        while ($data = mysqli_fetch_assoc($sql)) {
            $DCoutput .= "<tr>
                        <td>" . $data['FirstName'] . "</td>
                        <td>" . $data['LastName'] . "</td>
                        <td>" . $data['UserType'] . "</td>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['Other'] . "</td>
                        <td>" . $data['ticket_stat'] . "</td>
                        <td>" . $data['reasons'] . "</td>
                        <td>" . $data['DUPLICATES'] . "</td>
                    </tr>";
        }
        $DCoutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=DuplicateCustomers.xls");
        echo $DCoutput;
    }
    else{
        printAlert("There are no duplicate customers at this time.");
    }
}

if ($TD == 1)
{
    $i = 0;
    $connect = mysqli_connect($host, $user, $password, $database);
    $sql = mysqli_query($connect,
        "SELECT * FROM tranfer_detail where DATE BETWEEN '$StartDate' and '$EndDate' ORDER BY DATE ");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows > 0) {
        $TDoutput = '<table class = "table" bordered = "1">
                    <tr>
                        <th>Ticket_ID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>UserType</th>
                        <th>Issue</th>
                        <th>Other</th>
                        <th>ticket_stat</th>
                        <th>reasons</th>
                        <th>Date</th>
                        <th>Transfered By</th>
                        <th># Transfers/User</th>
                    </tr>';
        while ($data = mysqli_fetch_assoc($sql)) {
            $TDoutput .= "<tr>
                        <td>" . $data['ticket_ID'] . "</td>
                        <td>" . $data['FirstName'] . "</td>
                        <td>" . $data['LastName'] . "</td>
                        <td>" . $data['UserType'] . "</td>
                        <td>" . $data['Issue'] . "</td>
                        <td>" . $data['Other'] . "</td>
                        <td>" . $data['ticket_stat'] . "</td>
                        <td>" . $data['reasons'] . "</td>
                        <td>" . $data['Date'] . "</td>
                        <td>" . $data['transfered_by'] . "</td>
                        <td>" . $data['transfers'] . "</td>
                    </tr>";
        }
        $TDoutput .= "</table>";
        header("Content-Type: appliction/xls");
        header("Content-Disposition: attachment; filename=TransferDetail.xls");
        echo $TDoutput;
    }
    else{
        printAlert("There have been no tickets transfered more than once at this time.");
    }
}
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'Reports.php';
            </script>";
    die();
}
//puts dates into a standard format YYYY-MM-DD
//this section converts
function datavalidation ($date){
    $test_arr  = explode('-', $date);
    if (count($test_arr) == 3) {
        if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
            $one = $test_arr[0];
            $two = $test_arr[1];
            $three = $test_arr[2];
            if (strlen($three) > 3) {
                if (strlen($one) > 1 && strlen($two) > 1 ){
                    daysInMonthCheck($two, $one, $three);
                    $newarray = array($three, $one, $two);
                    $date = implode("-", $newarray);
                    return $date;
                }
                else{
                    printAlert("FFMonth and day must be two digits");
                }
            }
            else{
                printAlert("Date needs to be in MM-DD-YYYY format.");
            }
        }
        else{
            $one = $test_arr[0];
            $two = $test_arr[1];
            $three = $test_arr[2];
            if (strlen($one) > 3) {
                if (strlen($three) > 1 && strlen($two) > 1 ){
                    daysInMonthCheck($three, $two, $one);
                    $newarray = array($one, $two, $three);
                    $date = implode("-", $newarray);
                    return $date;
                }
                else{
                    printAlert("CMonth and day must be two digits");
                }
            }
            else{
                printAlert("Date needs to be in MM-DD-YYYY format.");
            }
        }
    }
    else{
        printAlert("Date needs to be in MM-DD-YYYY format");
    }
}
// this section is data validation
function daysInMonthCheck($days, $month, $year){
    if ($month == '04' || $month == '06' || $month == '09' || $month == '11' ){
        if ($days < 31 && $days > 0 ){
            return;
        }
        else{
            printAlert("The month you entered only has 30 days");
        }
    }
    //did not take into account leap year
    elseif ($month == '2' && $days > 0){
        if ((($days < 30 && $year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0))){
            return;
        }
        elseif ($days <29){
            return;
        }
        else{
            printAlert("Check the number of days in Frebuary this year.");
        }
    }
    elseif ($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month == '08' || $month == '10' || $month == '12' ){
        if ($days < 32 && $days > 0 ){
            return;
        }
        else{
            printAlert("The month you entered only has 31 days");
        }
    }
    else{
        printAlert("The date you entered is invalid");
    }
}
?>