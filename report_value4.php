

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
//Start of function for Total Customer
function total_customersF()
{

    $host="localhost";
    $user="root";
    $password="";
    $database="techinfo";
    $begindate= $_POST['beginDate'];
    $enddate =$_POST['endDate'];
    $connect = mysqli_connect($host, $user, $password, $database);
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

    }
    if (mysqli_query($connect, $sql)) {
        echo "New record created";
    } else {
        echo mysqli_error($connect);
    }
    mysqli_close($connect);
    return $sql;
}

//Page starts here
//gather values of checked boxes
if(isset($_POST['submit'])) {

    if (isset($_POST['check_list'])) {
        $optionArray = $_POST['check_list'];
        for ($i = 0; $i < count($optionArray); $i++) {
            echo $optionArray[$i] . "<br />";
            require('Classes/PHPExcel.php');
            //  $objPHPExcel = new PHPExcel();
            //  $objPHPExcel->getActiveSheet()->setTitle('Data');
            //  $rowNumber = 1;
            // $objPHPExcel->removeSheetByIndex()
            // while($row = $optionArray[i]){
            //     $newsheet = $objPHPExcel->createSheet();
            //     $col = 'A';
            //     $objPHPExcel->getActiveSheet()->setTitle($optionaArray[i]);
            //     foreach($row as $cell){
            //         $newsheet->setCellValue($col.$rowNumber,$cell);
            //
            //         col++;
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex($optionArray[$i]);
           // $objPHPExcel->$optionArray[$i]);
            $data = total_customersF();
            $rowCount = mysql_num_rows($data);
            while($row = mysqli_fetch_array($data)){
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['col1']);
                $rowCount++;
            }
            //$ews = $ea->getSheet(0);
            //$ews->setTitle($optionArray[0]);
            //$data = total_customersF();
            //$ews->setCellValue('a1', $data);
            //$ews->fromArray($data, 'Option Not selected', 'A2');


        }
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('TCS_Walkins.xlsx');
    }
}

//    if (!empty($_POST['check_list'])) {
//// Counting number of checked checkboxes.
//        $checked_count = count(!empty($_POST['check_list']));
//        $arr = (($_POST['check_list']));
//        echo "'$checked_count'";
//        for($i=0; $i <= $checked_count; $i++){
//            echo $arr[$i];
//            $i++;
//        }
//    }
//}
      /*  if ($checked_count > 0) {
            require('Classes/PHPExcel.php');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Data');
            $rowNumber = 1;
            $objPHPExcel->removeSheetByIndex()
            while($row = $arr){
                $newsheet = $objPHPExcel->createSheet();
                $col = 'A';
                $objPHPExcel->getActiveSheet()->setTitle($arr);
                foreach($row as $cell){
                    $newsheet->setCellValue($col.$rowNumber,$cell);
                    col++;
                }
            }
            //$phpExcel->getDefaultStyle()->getFont()->setName('Aril Black');
            //$phpExcel->getDefaultStyle()-getFont()->getSize(14);
            //$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
            //$row = 0
            foreach ($arr as &$value) {
                $newsheet = $objPHPExcel->createSheet();
                $col = 'A';
                $objPHPExcel->getActiveSheet()->setTitle($arr)
                echo $arr;
                echo $value;
            }

        }
        //header('Content-Type: application/vnd.ms-excel');
        //header('Content-Disposition: attachment;filename="TSC_Walkins_Reports.xls"');
        //$writer->save('php://output');
        //echo "You have selected following " . $checked_count . " option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
        //   foreach($_POST['check_list'] as $selected) {
        $connect = mysqli_connect($host, $user,$password, $database);
        /* check connection */
/*       if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "SELECT * FROM total_customers where Date between '$begindate' and '$enddate';";
        $sql .= "SELECT * FROM ticket_history";

        echo ("Queries ran");
        /* execute multi query */
  /*      if (mysqli_multi_query($connect, $sql)) {
            do {
                /* store first result set */
   /*             if ($result = mysqli_store_result($connect)) {
                    echo "stored the results";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "First Query works";
                    }
                    mysqli_free_result($result);
                }
                /* print divider */
  /*              if (mysqli_more_results($connect)) {
                    echo"Second Query ran";
                }
            } while (mysqli_next_result($connect));
        }
            echo "At least something is outputting";
        /* close connection */
  /*      mysqli_close($connect);






   /*     foreach ($_POST['check_list'] as $selected) {
            echo "Progress";
        }
    }
}*/



        /*$output .= '
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
*/


?>

