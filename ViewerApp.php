<?php
session_start();
if ($_SESSION['role']!="Viewer")
{
    header("Location: index.php");
}
?>
<html>
    <link rel="stylesheet" type="text/css" href="AppStyle.css">
    <link rel="stylesheet" type="text/css" href="CP.css">
    <link rel="stylesheet" type="text/css" href="HelpButton.css">
    <link rel="stylesheet" type="text/css" href="SELECT.css">
    <head><title>Application</title></head>
    <body>
        <h1><center>Viewer Application</center></h1>
        <form class="admin_form" id='logoff' action='Logout.php' method='GET'>
            <center><input class="EUsubmit" type="submit" value="Log Off"></center>
                <center><button class="SELECT" type="button" onclick="window.open('Reports.php')">Generate Reports</button></center>

                <div id="helpPOPUP" class="overlay">
                    <div class="popup">
                        <h2><center>Help</center></h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content">
                            This is the viewer application.
                            <br><br>
                            Within this app the viewer is able to see the current walk-in customers waiting to be helped in the TSC. This can be seen under the “Waiting Customers” section of the webpage.
                            <br><br>
                            The other section of this app shows the customers currently being helped in the TSC. This is shown under the “In-Progress Tickets” section of the application.
                            <br><br>
                            Another functionality of the viewer application is the ability to generate reports. By clicking the “Report Generator” button it takes you to the report generator application.
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
    </body>
</html>

<!--<center><input class="EUsubmit" type="button" value="Report Generator" onclick="window.open('Reports.php','',' scrollbars=no,menubar=no,width=500px,hight=300px,resizable=no,toolbar=no,location=no,status=no')"></center>-->

<br>
<center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
