<?php
session_start();
if ($_SESSION['role'] !='Admin')
{
    header("Location: index.php");
}
?>
<html>
<link rel="stylesheet" type="text/css" href="CP.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">
<head>
    <title>In-Progress Tickets</title>
</head>
<script type="text/javascript">
</script>
<body>
<h1 align="center">In-Progress Tickets</h1>
<center><input class="EUsubmit" type="button" value="Control Panel" onClick="window.location.href='AdminPanel.php'">
        <div class="box">
            <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
    </center>
    <div id="helpPOPUP" class="overlay" align="center">
        <div class="popup">
            <h2>Help</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                This page displays all the tickets currently open on the system.
                <br><br>
                Tickets that are open by an admin or tech are then marked as in-progress.
                <br><br>
                This page shows who is working on a specific ticket and allows another user to open that ticket.
                <br><br>
                The Control Panel button at the top of the page brings the user back to the Admin Control Panel.
            </div>
        </div>
    </div>

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
<br>
<center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
</body>
</html>