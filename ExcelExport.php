<?php
$StartDate =$_POST['beginDate'];
$EndDate = $_POST['endDate'];
$host="localhost";
$user="root";
$password="";
$database="techinfo";
$i = 0;
$connect = mysqli_connect($host,$user,$password,$database);
$sql = mysqli_query($connect,
"SELECT * FROM total_customers
WHERE ticket_stat = 'COMPLETED'
AND Date BETWEEN '$StartDate' AND '$EndDate' 
ORDER BY ticket_ID");
$num_rows = mysqli_num_rows($sql);
if ($num_rows >0)
{
    $output .='<table class = "table" bordered = "1">
                    <tr>
                        <th>Date</th>
                        <th>Ticket #</th>
                        <th>Technician</th>
                        <th>Remedy #</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>SSO ID</th>
                        <th>User Type</th>
                        <th>Issue</th>
                        <th>Details</th>
                    </tr>';
    while ($data = mysqli_fetch_assoc($sql)){
        $output .= "<tr>
                        <td>".$data['Date']."</td>
                        <td>".$data['ticket_ID']."</td>
                        <td>".$data['username']."</td>
                        <td>".$data['Remedy_no']."</td>
                        <td>".$data['LastName']."</td>
                        <td>".$data['FirstName']."</td>
                        <td>".$data['SSOID']."</td>
                        <td>".$data['UserType']."</td>
                        <td>".$data['Issue']."</td>
                        <td>".$data['Other']."</td>
                    </tr>";
    }
    $output .= "</table>";
    header("Content-Type: appliction/xls");
    header("Content-Disposition: attachment; filename=download.xls");
    echo $output;
}
