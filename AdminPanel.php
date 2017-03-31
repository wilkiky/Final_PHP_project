<?php
    //forces a user to be logged into the application before accessing this page
    session_start();
    if ($_SESSION['role']!="Admin")
    {
        header("Location: index.php");
    }
?>
<html>
    <link rel="stylesheet" type="text/css" href="CP.css">
    <link rel="stylesheet" type="text/css" href="HelpButton.css">
    <link rel="stylesheet" type="text/css" href="SELECT.css">
    <head>
        <title>Admin Control Panel</title>
    </head>
    <body>
        <h1 align="center">Admin Control Panel</h1>
        <form class="admin_form" id='logoff' action='Logout.php' method='GET'>
            <center><input class="EUsubmit" type="submit" value="Log Off"></center>
                <center><button class="SELECT" type="button" onclick="window.open('Student.php');">Select Customer</button></center>
            <div id="helpPOPUP" class="overlay" align="center">
                <div class="popup">
                    <h2>Help</h2>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                        This page is designed for administrator users to make adjustments to the system and have access to customer queue.
                        <br><br>
                        The names listed on the screen auto-refresh and are populated by the customers that sign-in to the system. Those customers can be selected using the “Select Customer” button. These customers will be selected on a first-in first-out basis.
                        <br><br>
                        <b>Generate Report</b> – This button is used to bring up the form that allows the admin to run system reports.
                        <br><br>
                        <b>In-Progress Tickets</b> – This button brings up the page that shows which tickets are currently being worked on and the employee that is working on that specific ticket.
                        <br><br>
                        <b>Edit User</b> – This button brings up the page used to edit the users of the system. This will allow an admin to Create, Edit, and Delete users from the system.
                        <br><br>
                        <b>Top Five Issues</b> - This button brings up the page used to edit the top five issues displayed to the customers when signing into the system.
                        <br><br>
                        <b>Maintenance</b> - This button brings up the page used to backup the current system and the databases associated with the system.
                    </div>
                </div>
            </div>

        </form>
        <table id="T1" cellspacing="7">
            <h2><center>Waiting Customers</center></h2>
            <!--creates refress of NEW customers in queue-->
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
            <tr>
                <!--<center><button class="CPsubmit" type="button" onclick="window.open('Student.php','',' scrollbars=no,menubar=no,' +
                    'width=500px,hight=300px,resizable=no,toolbar=no,location=no,status=no')">Select Customer</button>-->
                <center>
                <!--<button class="CPsubmit" type="button" onclick="window.location.href='Student.php';">Select Customer</button>-->
                    <!--                <button class="CPsubmit" type="button" onclick="window.open('Reports.php','',' scrollbars=no,menubar=no,' +
                                        'width=500px,hight=900px,resizable=no,toolbar=no,location=no,status=no')">Generate Reports</button>             -->
                    <button class="SELECT" type="button" onclick="window.location.href='AdminInProgress.php';">In-Progress Tickets</button>
                    <button class="SELECT" type="button" onclick="window.location.href='EditUser.php';">Edit User</button>
                    <button class="SELECT" type="button" onclick="window.location.href='TopFive.php';">Top Five Issues</button>
                </center>
            </tr>
            <tr>
                <center>
                <button class="SELECT" type="button" onclick="window.location.href='TylerBackup' +
                 '.php';">Maintenance</button>
                <button class="SELECT" type="button" onclick="window.open('Reports.php')">Generate Reports</button>
                </center>
            </tr>
            <br>
            <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
        </table>

    </body>
</html>