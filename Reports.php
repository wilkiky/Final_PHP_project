<?php
session_start();
if ($_SESSION['role'] !='Admin'){
    if ($_SESSION['role'] !='Viewer'){
        header("Location: index.php");
    }
}
?>
<html lang="en">
<head>
    <title>Reports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <link rel="stylesheet" type="text/css" href="reportStyle.css">
    <link rel="stylesheet" type="text/css" href="RADIO.css">
    <link rel="stylesheet" type="text/css" href="CP.css">
    <link rel="stylesheet" type="text/css" href="HelpButton.css">
    <head><title>Reports</title></head>
    <body>
        <h1><center>Create Reports</center></h1>
        <center><input class="EUsubmit" type="button" value="Exit" align="center" onClick="window.close()"></center>
        <div id="helpPOPUP" class="overlay" align="center">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    This is the reports page. This page is to be used to generate reports from the system. <br><br>
                    To generate a report a <b> beginning date </b> needs to be entered. <br><br>
                    Next, an <b> ending date </b> needs to be entered. <br><br>
                    Lastly, a <b> report </b> needs to be selected from the list of available reports. <br><br>
                    Press the <b> ‘Generate Report’ </b> button and an Excel spreadsheet will then begin downloading to your machine. <br><br>
                    After you are done downloading reports you can use the ‘Exit’ button to quit the application.
                </div>
            </div>
        </div>
        <form action='ExcelReport.php' method="post">
            <h3> Enter Beginning Date </h3> <input type="date" name= "beginDate" placeholder="YYYY-MM-DD" maxlength="20" required />&nbsp;
            <h3> Enter Ending Date</h3> <input type="date" name= "endDate" placeholder="YYYY-MM-DD" maxlength="20" required /><br><br>
            <div id="Reports">
                <h3> Reports </h3>
                <input type="radio" id="radio1" name="check_list[]" class="css3radio" value="total_customers"><label class="toggler_r" for="radio1">Total Completed Tickets</label>
                <input type="radio" id="radio2" name="check_list[]" class="css3radio" value="tech_performance_summary"><label class="toggler_r" for="radio2">Tech Performance Detail</label>
                <input type="radio" id="radio3" name="check_list[]" class="css3radio" value="unresolved_tickets"><label class="toggler_r" for="radio3">Unresolved Tickets</label>
                <input type="radio" id="radio4" name="check_list[]" class="css3radio" value="incident_tracking"><label class="toggler_r" for="radio4">Incidents</label>
                <input type="radio" id="radio5" name="check_list[]" class="css3radio" value="duplicate_customers"><label class="toggler_r" for="radio5">Repeat Customers</label>
                <input type="radio" id="radio6" name="check_list[]" class="css3radio" value="overdue_tickets"><label class="toggler_r" for="radio6">Outstanding Tickets</label>
                <input type="radio" id="radio7" name="check_list[]" class="css3radio" value="multiple_transfers"><label class="toggler_r" for="radio7">Multiple Transfers</label>
                <br>
                <input class="submit" type="submit" value="Generate Report" name="submit"><br><br>
            </div>
        </form>
        <center><a href="#helpPOPUP"><button class="HELPbutton">Help</button></a></center>
    </body>
</html>