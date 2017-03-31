<?php
$begindate = $_GET['beginDate'];
$enddate = $_GET['endDate'];
$connect = mysqli_connect($host, $user, $password, $database);
             $output = '';
             $sql = "SELECT * FROM technician_availability";
             $result = mysqli_query($connect, $sql);
             if (mysqli_num_rows($result) > 0) {
                 $output .= '
                         <table class="table" bordered="1">
                          <tr>
                             <th>Date</th>
                             <th>Technican</th>
                         </tr>
                       ';
                 while ($row = mysqli_fetch_array($result1)) {
                    $output .= '
                         <tr>
                             <td>' . $row['date'] . '</td>
                             <td>' . $row['username'] . '</td>
                         </tr>
                      ';
                 }                 $output .= '</table>';
                 header("Content-Type: application/xls");
                 header("Content-Disposition:attachment; filename=technician_availability.xls");
                 echo $output;






// echo "<p>".$selected ."</p>";

} else {
    echo "<b>Please Select At least One Option.</b>";
}
//

//
?>