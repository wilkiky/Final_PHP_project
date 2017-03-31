<?php
    session_start();

   // runDB_B();
   // function runDB_B()
  //  {

 //       echo "<script language='javascript'>
 //          window.location.href = 'DB_Backup.php'
 //           </script>";
//
//    }
    //sets $_Session['username'] as a global variable
    $_SESSION['username']= $_GET['username'];
    //Username and Password need to be collected in index.html verified in MySQL and can be rerouted to the appropriate Tech/Admin page based on the user's role
    $TechUsername =$_GET['username'];   //should use post but can't get it to work
    $TechPassword =$_GET['password'];   //should use post but can't get it to work
    $TechRole = "";
    $errorMessage ="";
    //Server Access
    $host="localhost";
    $user="root";
    $password="";
    $database="techinfo";
    //Creates Timestam
    $defaultTimeZone = new DateTimeZone("America/Chicago");
    $date = new DateTime("now", $defaultTimeZone);
    $start_date = $date->format("Y-m-d");

    $Active = "";

    $connect = mysqli_connect($host,$user,$password,$database);
    if(!$connect)
    {
        die("Connection Failed");
    }
    $sql = mysqli_query($connect, "SELECT * FROM technicians WHERE username= '$TechUsername' AND password = '$TechPassword'");
    $num_rows = mysqli_num_rows($sql);
    if ($num_rows < 1)
    {
        printAlert("Wrong Username or Password");
    }
    while ($row = mysqli_fetch_assoc($sql))
    {
        //assign role from technician database to local variable $TechRole
        $TechRole = $row['role'];
        //assign end_date (date tech was deleted) from technician database to local variable $$Active
        $Active = $row['end_date'];
    }
    if ($Active != null)
    {
        printAlert("Disabled Account");
    }
    else
    {
        if ($TechRole == 'Admin')
        {
            if ($num_rows > 0)
            {
                //SETS TECHNICIANS AVAILABILITY TO TRUE
                $sql = "UPDATE technicians SET last_log_date = '$start_date'  WHERE username = '$TechUsername'";
                echo $start_date;
                if ($connect->query($sql) === TRUE)
                {
                    echo "Record updated successfully";
                }
                else
                {
                    echo "Error updating record: " . $connect->error;
                }
                //sets $_SESSION['role'] as a global variable
                $_SESSION['role'] = "$TechRole";
                header("Location:AdminPanel.php");
            }
            else
            {
                if (!$row)
                {
                    printAlert("Wrong Username or Password");
                }
            }
        }
        elseif ($TechRole == 'StaffTech' || $TechRole == 'StudentTech')
        {
            if ($num_rows > 0)
            {
                if ($num_rows > 0)
                {
                    //SETS TECHNICIANS AVAILABILITY TO TRUE
                    $sql = "UPDATE technicians SET last_log_date = '$start_date'  WHERE username = '$TechUsername'";
                    echo $start_date;
                    if ($connect->query($sql) === TRUE)
                    {
                        echo "Record updated successfully";
                    }
                    else
                    {
                        echo "Error updating record: " . $connect->error;
                    }
                    //sets $_SESSION['role'] as a global variable
                    $_SESSION['role'] = "$TechRole";
                    header("Location:Queue.php");
                }
                else
                {
                    if (!$row)
                    {
                        printAlert("Wrong Username or Password");
                    }
                }
            }
        }
        elseif ($TechRole == 'Viewer')
        {
            if ($num_rows > 0)
            {
                if ($num_rows > 0)
                {
                    //SETS TECHNICIANS AVAILABILITY TO TRUE
                    $sql = "UPDATE technicians SET last_log_date = '$start_date'  WHERE username = '$TechUsername'";
                    echo $start_date;
                    if ($connect->query($sql) === TRUE)
                    {
                        echo "Record updated successfully";
                    }
                    else
                    {
                        echo "Error updating record: " . $connect->error;
                    }
                    //sets $_SESSION['role'] as a global variable
                    $_SESSION['role'] = "$TechRole";
                    header("Location:ViewerApp.php");
                }
                else
                {
                    if (!$row)
                    {
                        printAlert("Wrong Username or Password");
                    }
                }
            }
        }
    }
function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'index.php';
//            window.location.href = 'DB_Backup.php'
            </script>";
    die();
}
?>