<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php

session_start();
if ($_SESSION['role'] !='Admin')
{
    if ($_SESSION['role'] !='Viewer')
    {
        header("Location: index.php");
    }
}
?>

<link rel="stylesheet" type="text/css" href="reportStyle.css">
<link rel="stylesheet" type="text/css" href="CP.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">
<!--
    <head><title>Reports</title></head>
    <body> -->
            <h1><center>Create Reports</center></h1>

            <center><input class="EUsubmit" type="button" value="Exit" align="center" onClick="window.close()"></center>
            <div class="box">
                <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
            </div>
            <div id="helpPOPUP" class="overlay">
                <div class="popup">
                    <h2>Help</h2>
                    <a class="close" href="#">&times;</a>
                        <div class="content">
                            Enter Help Crap Here
                        </div>
                </div>
            </div><br><br>
       <!-- <div class="container">
            <div class="main">-->
        <h2 align="center">Report Generator</h2>
        <form action='report_value5.php' method="post">
           <h3> Input Begining Date </h3> <input type="text" name="beginDate" placeholder="Begin Date" maxlength="20" required />&nbsp;&nbsp;&nbsp;<h3> Input Ending Date</h3> <input type="text" name="endDate" placeholder="End Date" maxlength="20" required /><br><br>
            <div>
                <label class="heading">Select Which Reports do you want to Run:</label>
                <input type="checkbox" id="checkbox1" class="css3checkbox" name="check_list[]" value="total_customers" >
                <label class="toggler" for="checkbox1">All Tickets Completed</label><br>
                <input type="checkbox" id="checkbox2" class="css3checkbox" name="check_list[]" value="technician_availability">
                <label class="toggler" for="checkbox2">Technician Availability</label><br>
                <input class="submit" type="submit" name="submit"  value="Export to Excel"/>
            <!----- Including PHP Script ----->
            <?php //include 'report_value.php';?>
            </div>
        </form>


















      <!--          </div>
            </div>-->
           <!-- </div>
 <!--    <form action="Reports2.php" method="get">
                   <input name="Report1" type="checkbox" value="//
                    <input type="submit" value="send">
                </form>
                <input type="checkbox" id="checkbox1" value="Report1" />
                //<label class="toggler" for="checkbox[]">Report 1</label>
                <input type="checkbox" id="checkbox[]" class="css3checkbox" />
                //<label class="toggler" for="checkbox2">Report 2</label>
                <input type="checkbox" id="checkbox[]" class="css3checkbox" />
                //<label class="toggler" for="checkbox[]">Report 3</label>
                <input type="checkbox" id="checkbox[]" class="css3checkbox" />
                //<label class="toggler" for="checkbox4">Report 4</label>
                <input type="checkbox" id="checkbox[]" class="css3checkbox" />
                //<label class="toggler" for="checkbox5">Report 5</label>
                <input type="checkbox" id="checkbox[]" class="css3checkbox" />
                //<label class="toggler" for="checkbox6">Report 6</label>
            </div>
        </form><br><br>

      <center><input class="submit" type="button" value="Generate Report" onclick=""></center>
-->
<br><br>
<center><a href="#helpPOPUP"><button class="HELPbutton">Help</button></a></center>
    </body>
</html>
