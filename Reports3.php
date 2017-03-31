<html>
<link rel="stylesheet" type="text/css" href="reportStyle.css">
<link rel="stylesheet" type="text/css" href="CP.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">


    <head><title>Reports</title></head>
    <body>
        <h1><center>Create Reports</center></h1>
        <center><input class="EUsubmit" type="button" value="Exit" align="center" onClick="window.close()"></center>
            <div class="box">
               <!-- <a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a> -->
            </div>
        <div id="helpPOPUP" class="overlay" align="center">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    Enter Help Crap Here
                    <br>
                    more stuff
                    <br>
                    more stuff
                </div>
            </div>
        </div>

        <br><br>

            <form action='report_value4.php' method="post">
                <h3> Input Begining Date </h3> <input type="text" name="beginDate" placeholder="Begin Date" maxlength="20" required />&nbsp;&nbsp;&nbsp;<h3> Input Ending Date</h3> <input type="text" name="endDate" placeholder="End Date" maxlength="20" required /><br><br>
                <input type="checkbox" name="check_list[]" value="total_customers"><label>Total Customers</label><br/>
                <input type="checkbox" name="check_list[]" value="technician_availability"><label>Technician Availiability</label><br/>
                <input type="submit" name="submit" value="Generate Reports"/>
            </form>
        </form><br><br>

        <br><br>
        <center><a href="#helpPOPUP"><button class="HELPbutton">Help</button></a></center>
    </body>
</html>