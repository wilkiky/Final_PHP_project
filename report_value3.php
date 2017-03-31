

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
$output = '';
//connection to server

//if unable to connect
if(isset($_POST['submit'])) {
    if (!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
        $checked_count = count($_POST['check_list']);
        //echo "You have selected following " . $checked_count . " option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
        //   foreach($_POST['check_list'] as $selected) {
        // foreach ($_POST['check_list'] as $selected) {
        //if ($_Post['value']= "total_customers"){
        // if ($selected = "All Tickets Completed") {
        $connect = mysqli_connect($host, $user, $password, $database);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "SELECT * FROM total_customers where Date between '$begindate' and '$enddate';";
        $sql .= "SELECT * FROM ticket_history";

// Execute multi query
        if (mysqli_multi_query($connect, $sql)) {
            do {
                // Store first result set
                if ($result = mysqli_store_result($connect)) {
                    while ($row = mysqli_fetch_row($result)) {
                        foreach ($_POST['check_list'] as $selected) {
                            if ($selected = "All Tickets Completed") {
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
                                // while ($row = mysqli_fetch_array($result)) {
                                while ($row = mysqli_use_result($result)) {
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
                            //header("Content-Type: application/xls");
                            //header("Content-Disposition:attachment; filename=total_customers.xls");
                            // echo $output;
                        }
                        elseif ($selected = "Technician Availability"){
                        $output .= '
                                        <table class="table" bordered="1">
                                            <tr>
                                              <th>Date</th>
                                              <th>Technican</th>
                                            </tr>
                                        ';
                        while ($row = mysqli_fetch_array($result)) {
                            $output .= '
                                           <tr>
                                            <td>' . $row['date'] . '</td>
                                            <td>' . $row['username'] . '</td>
                                           </tr>
                                        ';
                        }
                        $output .= '</table>';
                        // header("Content-Type: application/xls");
                        // header("Content-Disposition:attachment; filename=technician_availability.xls");
                        // echo $output;
                        echo "The second part works";
                        echo "Why doesn' this output anything?";

                    }else {
                        echo "Please make a selection";
                    }
                            // Free result set
                            mysqli_free_result($result);
                        }
                    }
                }
            }while (mysqli_next_result($connect)) ;


            }
        mysqli_close($connect);
    }

}


?>
