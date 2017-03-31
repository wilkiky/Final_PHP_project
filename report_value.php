

<?php
//Variables from TopFive.php
//$checklist[] = $_GET['Current'];

//Server Connection
$host="localhost";
$user="root";
$password="";
$database="techinfo";
$begindate= $_POST['beginDate'];
$enddate =$_POST['endDate'];
//connection to server

//if unable to connect
if(isset($_POST['submit'])) {
    if (!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
        $checked_count = count($_POST['check_list']);
        //echo "You have selected following " . $checked_count . " option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
        //   foreach($_POST['check_list'] as $selected) {
        foreach ($_POST['check_list'] as $selected) {
            //if ($_Post['value']= "total_customers"){
            if ($selected = "total_cusotmers") {
                $connect = mysqli_connect($host, $user, $password, $database);
                $output = '';
                $sql = "SELECT * FROM total_customers where Date between '$begindate' and '$enddate'";
                $result = mysqli_query($connect, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $output .= '
                            <table class="table" bordered="1">
                             <tr>
                                <th>FirstName</th>
                                <th>Issue</th>
                                <th>LastName</th>
                                <th>Other</th>
                                <th>Remedy_no</th>
                                <th>SSOID</th>
                                <th>ticket_ID</th>
                                <th>ticket_stat</th>
                                <th>username</th>
                                <th>UserType</th>
                                <th>Date</th>
                            </tr>
                          ';
                    while ($row = mysqli_fetch_array($result)) {
                        $output .= '
                            <tr>
                                <td>' . $row['FirstName'] . '</td>
                                <td>' . $row['Issue'] . '</td>
                                <td>' . $row['LastName'] . '</td>
                                <td>' . $row['Other'] . '</td>
                                <td>' . $row['Remedy_no'] . '</td>
                                <td>' . $row['ticket_ID'] . '</td>
                                <td>' . $row['ticket_stat'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['UserType'] . '</td>
                                <td>' . $row['Date'] . '</td>                                                               
                            </tr>
                         ';
                    }
                    $output .= '</table>';
                    header("Content-Type: application/xls");
                    header("Content-Disposition:attachment; filename=total_customers.xls");
                    echo $output;
                    echo "The first part works";
                    mysqli_free_result($result);
                    mysqli_close($connect);
                }
           } elseif ($selected = "technician_availability") {
                $connect = mysqli_connect($host, $user, $password, $database);
                $output = '';
                $sql = "SELECT * FROM ticket_history";
                $result = mysqli_query($connect, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $output .= '
                            <table class="table" bordered="1">
                             <tr>
                              <th>History ID</th>
                                <th>Ticket_ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Event</th>
                                <th>Technician</th>
                            </tr>
                          ';
                    while ($row = mysqli_fetch_array($result)) {
                        $output .= '
                            <tr>
                               <td>' . $row['history_ID'] . '</td>
                                <td>' . $row['Date'] . '</td>
                                <td>' . $row['Time'] . '</td>
                                <td>' . $row['Event'] . '</td>
                                <td>' . $row['username'] . '</td>
                            </tr>
                         ';
                    }
                    $output .= '</table>';
                    header('Reports2.php');
                    header("Content-Type: application/xls");
                    header("Content-Disposition:attachment; filename=technician_availability.xls");
                    echo $output;
                    echo "The second part works";
                    mysqli_free_result($result);
                    mysqli_close($connect);
                    echo "Why doesn' this output anything?";
                }
                else
                    echo "There are no records for "& $selected & "for those dates.";

            }


            // echo "<p>".$selected ."</p>";
        }
    } else {
        echo "<b>Please Select At least One Option.</b>";
    }
    //
}
//
?>

