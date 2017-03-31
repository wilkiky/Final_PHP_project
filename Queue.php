<?php
//forces a user to be logged into the application before accessing this page
session_start();
if ($_SESSION['role']!='StaffTech')
{
    if ($_SESSION['role']!='StudentTech')
    {
        header("Location: index.php");
    }
}
?>

<html>
    <link rel="stylesheet" type="text/css" href="AppStyle.css">
    <link rel="stylesheet" type="text/css" href="CP.css">
    <link rel="stylesheet" type="text/css" href="HelpButton.css">
    <link rel="stylesheet" type="text/css" href="SELECT.css">
    <head><title>Application</title></head>
    <body>
        <h1><center>Customer Queue Application</center></h1>
        <form class="admin_form" id='logoff' action='Logout.php' method='GET'>
            <center><input class="EUsubmit" type="submit" value="Log Off"></center>
            <center><button class="SELECT" type="button" onclick="window.open('Student.php');">Select Customer</button></center>

            <div id="helpPOPUP" class="overlay" align="center">
                <div class="popup">
                    <h2>Help</h2>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                        The Customer Queue Application is the application technicians use to view the customers that have walked in to the TSC. <br><br>
                        The customers under the <b> ‘Waiting Customers’ </b> section are the current customers that have not been helped yet. <br><br>
                        To help these customers press <b> ‘Select Customer’ </b> button and it will automatically pull the ticket for the first customer in the wait list. <br><br>
                        Under the ‘Select Customer’ button is the <b> ‘In-Progress Tickets’ </b> That list will populate three different things. Tickets currently being worked on, tickets that have been transferred, and tickets that are pending and need attention. <br><br>
                        To open one of those tickets in the ‘In-progress’ section press the <b> ‘Open’ </b> button beside the ticket you are wanting to open. <br><br>
                        <b> Please note: Any ticket that you open or select will become your ticket. Your name will be placed as the owner of that walk-in ticket. </b>
                    </div>
                </div>
            </div>
        </form>
        <!--creates refress of NEW customers in queue-->
        <h2><center>Waiting Customers</center></h2>
        <div id="reload"></div>
        <script type="text/javascript" src="jquery-3.1.1.js"></script>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                $('#reload').load('NewTickets.php')
                refresh();
            });
            function refresh()
            {
                setTimeout(function ()
                {
                    $('#reload').fadeOut('slow').load('NewTickets.php').fadeIn('slow');
                    refresh();
                }, 6500);
            }
        </script>
        <!--ends reload script-->



        <h2><center>In-Progress Tickets</center></h2>
    <table>
        <!--creates refress of In-Progress customers in queue-->
        <div id="reload2"></div>
        <script type="text/javascript" src="jquery-3.1.1.js"></script>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                $('#reload2').load('InProgressTickets.php')
                refresh2();
            });
            function refresh2()
            {
                setTimeout(function ()
                {
                    $('#reload2').fadeOut('slow').load('InprogressTickets.php').fadeIn('slow');
                    refresh2();
                }, 6500);
            }
        </script>
        <!--ends reload script-->

    </table>
        <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
    </body>
</html>