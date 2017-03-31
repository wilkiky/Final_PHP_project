<?php
/**
 * Created by PhpStorm.
 * User: kkmt
 * Date: 12/8/2016
 * Time: 7:08 PM
 */

//$_SESSION['startdate'] = $_POST['beginDate'];
//$_SESSION['enddate'] = $_POST['endDate'];
$StartDate = $_POST['beginDate'];
$EndDate = $_POST['endDate'];
$host = "localhost";
$user = "root";
$password = "";
$database = "techinfo";
//$StartDate = datavalidation($StartDate);
//$EndDate = datavalidation($EndDate);
$tables = array('technicians', 'ticket', 'ticket_history');
$length = count($tables);
$bu = false;
$at = false;
$as = false;
$ah = false;
$af = false;
$dr = false;
$StartDate = datavalidation($StartDate);
$EndDate = datavalidation($EndDate);

//if end date is before start date
if($EndDate < $StartDate){
    printAlert("End date cannot be before start sate");
}

if(isset($_POST['submit'])) {
    if (!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
        $checked_count = count($_POST['check_list']);
// Loop to store and display values of individual checked checkbox.
        foreach ($_POST['check_list'] as $choice) {
            if ($choice == "back_up") {
                $bu = true;
            }
            if ($choice == "arch_ticket") {
                $at = true;
            }
            if ($choice == "arch_ticket_history") {
                $ah = true;
            }
            if ($choice == 'arch_tech') {
                $as = true;
            }
            if ($choice == 'arch_TopFive') {
                $af = true;
            }

        }

    } else {
        echo "You did not make a valid select please choose again";
        header("Location: Archive.php");
    }

}
    if ($at == true) {

        $connect = mysqli_connect($host, $user, $password, $database);
        $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
        mysqli_select_db($connect, $database);
        $Ticketsql = "SELECT t.ticket_ID, t.FirstName, t.LastName, t.SSOID, t.username, t.UserType, t.Issue, t.Other, t.ticket_stat, t.reasons, t.Remedy_no
                FROM ticket t
                Where t.ticket_stat IN ('COMPLETED', 'UNRESOLVED')
    and EXISTS(Select * from ticket x
			                JOIN ticket_history y 
                            ON x.ticket_ID = y.ticket_ID
                            where y.Date Between '$StartDate' and '$EndDate' and y.Event in ('Closed' or 'Unresolved'))";
        $result = mysqli_query($connect, $Ticketsql);
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            mysqli_query($connect, "INSERT INTO arch_tickets VALUES ('$line[ticket_ID]', '$line[FirstName]', '$line[LastName]', '$line[SSOID]','$line[username]','$line[UserType]','$line[Issue]','$line[Other]','$line[ticket_stat]','$line[reasons]', '$line[Remedy_no]')");
        }
        mysqli_query($connect, "DELETE ticket FROM ticket JOIN arch_tickets ON ticket.ticket_ID = arch_tickets.ticket_ID");

        unset($connect);
         printAlert("Your data has been archvied " );
         header("Location: TylerBackup.php");
    }


    if ($as == true) {

        $connect = mysqli_connect($host, $user, $password, $database);
        $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
        mysqli_select_db($connect, $database);
        $Techsql = "SELECT username, Password, FName, LName, start_date, Last_log_date, end_date, e_mail, role FROM technicians WHERE end_date between '$StartDate' and '$EndDate'";
        $result = mysqli_query($connect, $Techsql);
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            mysqli_query($connect, "INSERT INTO arch_technicians VALUES ('$line[username]', '$line[Password]', '$line[FName]', '$line[LName]', '$line[start_date]', '$line[Last_log_date]', '$line[end_date]', '$line[e_mail]', '$line[role]' )");
        }
        //echo 'Second Table';
        mysqli_query($connect, "DELETE technicians FROM technicians WHERE end_date IS NOT NULL ");
        unset($connect);
        printAlert("Your data has been archvied ");
        header("Location: TylerBackup.php");
    }

    //  header("Location: Archive2.php?StartDate='$StartDate'&?EndDate='$EndDate'");
    if ($ah == true) {
        $connect = mysqli_connect($host, $user, $password, $database);
        $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
        mysqli_select_db($connect, $database);
        $Histsql = "SELECT h.* FROM ticket_history h JOIN arch_tickets a ON h.ticket_ID = a.ticket_ID";
        $result = mysqli_query($connect, $Histsql);
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            mysqli_query($connect, "INSERT INTO arch_ticket_history VALUES ('$line[history_ID]', '$line[ticket_ID]', '$line[Date]', '$line[Time]', '$line[Event]', '$line[username]', '$line[transfered_by]')");

        }
        mysqli_query($connect, "DELETE ticket_history FROM ticket_history JOIN arch_ticket_history ON ticket_history.history_ID = arch_ticket_history.history_ID");
        unset($connect);
        printAlert("Your data has been archvied ");
        header("Location: TylerBackup.php");

        // echo 'Ticket History';
    }
    if ($af == true) {
        $connect = mysqli_connect($host, $user, $password, $database);
        $sql = mysqli_query($connect, 'SET FOREIGN_KEY_CHECKS=0');
        mysqli_select_db($connect, $database);
        $Fivesql = "SELECT Issue,Selected FROM topfive WHERE Selected = 0 AND Issue != 'Other'";
        $result = mysqli_query($connect, $Fivesql);
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            mysqli_query($connect, "INSERT INTO arch_five VALUES ('$line[Issue]', '$line[Selected]')");
        }
        mysqli_query($connect, "DELETE topfive FROM topfive WHERE Selected = 0 AND Issue != 'Other'");

        unset($connect);
        printAlert("Your data has been archvied ");
        header("Location: TylerBackup.php");


    }


    if ($bu == true) {

        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $name = 'techinfo';
        $tables = '*';
        //backup_tables('localhost', 'root', '', 'techinfo', 'tables');
        // backup_tables('localhost', 'root', '', 'techinfo');

        //backup the db OR just a table */



        $connect = mysqli_connect($host, $user, $pass, $name);
        mysqli_select_db($connect, $name);

        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query($connect, 'SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        $return = null;
        //cycle through
        foreach ($tables as $table) {
            $result = mysqli_query($connect, 'SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($connect, 'SHOW CREATE TABLE ' . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_ireplace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }

        //save file
        //  $handle = fopen('db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql', 'w+');
        //file = fopen("ftp://user:password@example.com/test.txt","w");
        $handle = fopen('C:\xampp\TSC-DB-backup.sql', 'w+');
        fwrite($handle, $return);
        fclose($handle);
        printAlert("Your backup file has been populated");
        header("Location: TylerBackup.php");



}
    function printAlert($text)
    {
        echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'TylerBackup.php';
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
                if (strlen($three) > 3) {
                    if (strlen($one) > 1 && strlen($two) > 1) {
                        daysInMonthCheck($two, $one, $three);
                        $newarray = array($three, $one, $two);
                        $date = implode("-", $newarray);
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
                    if (strlen($three) > 1 && strlen($two) > 1) {
                        daysInMonthCheck($three, $two, $one);
                        $newarray = array($one, $two, $three);
                        $date = implode("-", $newarray);
                        return $date;
                    } else {
                        printAlert("CMonth and day must be two digits");
                    }
                } else {
                    printAlert("Date needs to be in MM-DD-YYYY format.");
                }
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

?>