<?php
$begindate = $_GET['beginDate'];
$enddate = $_GET['endDate'];
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
}
