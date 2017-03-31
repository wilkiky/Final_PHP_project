<?php
/**
 * Created by PhpStorm.
 * User: kkmt
 * Date: 11/24/2016
 * Time: 1:25 PM
 */
function total_customers()
{

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "techinfo";
    $begindate = $_POST['beginDate'];
    $enddate = $_POST['endDate'];
    $connect = mysqli_connect($host, $user, $password, $database);
    $output = '';
//if unable to connect to server
    if (!$connect) {
        die("Connection Failed");
    }
//technician is created and sent to technicians table
// $sql = "INSERT INTO techinfo.technicians (username, Password, FName, LName, start_date, last_log_date, available, end_date, e_mail, role)
//  VALUES ('$UName', '$Pass','$FName', '$LName', '$start_date', '', '0', '$email', '$Role',)";
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

}

function technican_availability()
{
    $host="localhost";
    $user="root";
    $password="";
    $database="techinfo";
    $begindate= $_POST['beginDate'];
    $enddate =$_POST['endDate'];

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
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment; filename=technician_availability.xls");
        echo $output;
        echo "The second part works";
        mysqli_free_result($result);
        mysqli_close($connect);
    }
}
// Actually start from checking options from previous page
if(isset($_POST['submit'])) {

    if (isset($_POST['check_list'])) {
        require('Classes/PHPExcel.php');
        $objPHPExcel = new PHPExcel;
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0)->setTitle('TSC Report Summary');
        $rowCount = 1;


        $optionArray = $_POST['check_list'];
        for ($i = 0; $i < count($optionArray); $i++) {
            echo $optionArray[$i] . "<br />";
            require('Classes/PHPExcel.php');
            $objWorksheet = $objPHPExcel->createSheet($i);
            $objPHPExcel->addSheet($objWorksheet);
            $objPHPExcel->setActiveSheetIndex($i);
            $objWorksheet->setTitle('', $optionArray[$i]);
            switch($i){
                case 0: $data = total_customers();
                    break;
                case 1: $data = technican_availability();
                    break;
            }

           // $objWorksheet->setCellValue('A'.'2', $data);

        }
        header("Location: Reports2.php");
       // header('Content-Type : applicant/vnd.ms-excel');
       // header('Content-Disposition: attachment;filename ="TSC Reports.xlsx');
       // header('Cache-Control: max-age=0');
       // $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       // $writer->save('php://output');

    }
}
