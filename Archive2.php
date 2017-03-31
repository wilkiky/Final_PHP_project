<?php
/**
 * Created by PhpStorm.
 * User: kkmt
 * Date: 12/8/2016
 * Time: 7:08 PM
 */


$StartDate = $_GET['startdate'];
$EndDate = $_Get['enddate'];
$host = "localhost";
$user = "root";
$password = "";
$database = "techinfo";
//$StartDate = datavalidation($StartDate);
//$EndDate = datavalidation($EndDate);
//$tables = array('technicians', 'ticket', 'ticket_history', 'topfive');
//$length = count($tables);
//$tc = false;


//if($StartDate < $StartDate {
  //  printAlert("End date cannot be before start date");

//}



                    $connect = mysqli_connect($host, $user, $password, $database);
                    $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
                    mysqli_select_db($connect, $database);
                            $Techsql = "SELECT username, Password, FName, LName, start_date, Last_log_date, end_date, e_mail, role FROM `technicians` WHERE end_date between '$StartDate' and '$EndDate'";
                            $result = mysqli_query($connect, $Techsql);
                            while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                mysqli_query($connect, "INSERT INTO arch_technicians VALUES ('$line[username]', '$line[Password]', '$line[FName]', '$line[LName]', '$line[start_date]', '$line[Last_log_date]', '$line[end_date]', '$line[e_mail]', '$line[role]' )");
                            }
                            echo 'Second Table';
                    unset($connect);
                    header("Location: Archive_ticket_history.php?StartDate = $StartDate&?EndDate = $EndDate");

             /*   case 'ticket_history':
                        $connect = mysqli_connect($host, $user, $password, $database);
                        $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
                        mysqli_select_db($connect, $database);
                            $Histsql = "SELECT DISTINCT h.history_ID, h.ticket_ID, h.Date, h.Time, h.Event, h.username, h.transfered_by 
                            FROM ticket_history h 
                            JOIN ticket t 
                            ON h.ticket_ID = t.ticket_ID
                            WHERE t.ticket_stat = 'COMPLETED' AND  h.Date BETWEEN '2016/11/01' AND '2016/12/01'";
                            $result3 = mysqli_query($connect, $Histsql);
                            while ($line = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                                mysqli_query($connect, "INSERT INTO arch_ticket_history VALUES ('$line[history_ID]', '$line[ticket_ID]', '$line[Date]', '$line[Time]', '$line[Event]', '$line[username]', '$line[transfered_by]'");

                            }
                                echo 'Ticket History';
                                break;
                case 'topfive':
                    $connect = mysqli_connect($host, $user, $password, $database);
                    $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
                    mysqli_select_db($connect, $database);
                            $Fivesql = "SELECT Issue, Selected FROM topfive WHERE Selected = 0";
                            $result4 = mysqli_query($connect, $Fivesql);
                            while ($line = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
                                mysqli_query($connect, "INSERT INTO arch_five VALUES ('$line[Issue]', '$line[Selected]'");
                            }
                                echo 'Top Five';
                            break;
                    default:




            }
        }




    function printAlert($text)
    {
        echo "<script language='javascript'>
            alert('$text');
//            window.location.href = 'Reports.php';
            </script>";
        die();
    }

//puts dates into a standard format YYYY-MM-DD
//this section converts
    function datavalidation($date)
    {
        $test_arr = explode('-', $date);
        if (count($test_arr) == 3) {
            if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
                $one = $test_arr[0];
                $two = $test_arr[1];
                $three = $test_arr[2];
                echo "Three = " . $three;
                echo "Three count is  = " . strlen($three);
                if (strlen($three) > 3) {
                    if (strlen($one) > 1 && strlen($two) > 1) {
                        daysInMonthCheck($two, $one, $three);
                        $newarray = array($three, $one, $two);
                        $date = implode("-", $newarray);
                        echo "The date is " . $date;
                        return $date;
                    } else {
                        printAlert("FFMonth and day must be two digits");
                    }
                } else {
                    printAlert("Date needs to be in MM-DD-YYYY format.");
                }
            } else {
                $one = $test_arr[0];
                $two = $test_arr[1];
                $three = $test_arr[2];
                if (strlen($one) > 3) {
                    echo "3 = " . strlen($three);
                    echo "2 = " . strlen($two);
                    if (strlen($three) > 1 && strlen($two) > 1) {
                        daysInMonthCheck($three, $two, $one);
                        $newarray = array($one, $three, $two);
                        $date = implode("-", $newarray);
                        echo "The else date is " . $date;
                        return $date;
                    } else {
                        printAlert("CMonth and day must be two digits");
                    }
                } else {
                    printAlert("Date needs to be in MM-DD-YYYY format.");
                }
                echo "else responce " . $date;
                return $date;
            }
        } else {
            printAlert("Date needs to be in MM-DD-YYYY format");
        }
    }

// this section is data validation
    function daysInMonthCheck($days, $month, $year)
    {
        if ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
            if ($days < 31 && $days > 0) {
                return;
            } else {
                printAlert("The month you entered only has 30 days");
            }
        } //did not take into account leap year
        elseif ($month == '2' && $days > 0) {
            if ((($days < 30 && $year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0))) {
                return;
            } elseif ($days < 29) {
                return;
            } else {
                printAlert("Check the number of days in Frebuary this year.");
            }
        } elseif ($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month == '08' || $month == '10' || $month == '12') {
            if ($days < 32 && $days > 0) {
                return;
            } else {
                printAlert("The month you entered only has 31 days");
            }
        } else {
            printAlert("The date you entered is invalid");
        }

}
*/
?>