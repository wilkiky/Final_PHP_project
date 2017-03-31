<?php
session_start();
if ($_SESSION['role'] !='Admin')
{
    header("Location: index.php");
}
?>
<html lang="en">
<head>
    <title>Backup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<link rel="stylesheet" type="text/css" href="HelpButton.css">
<link rel="stylesheet" type="text/css" href="RADIO.css">
<link rel="stylesheet" type="text/css" href="reportStyle.css">
<link rel="stylesheet" type="text/css" href="CP.css">



<h1><center>Maintenance</center></h1>
<center><input class="EUsubmit" type="button" value="Control Panel" onClick="window.location.href='AdminPanel.php'"></center>


<div id="helpPOPUP" class="overlay" align="center">
    <div class="popup">
        <h2>Help</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            This is the database maintenance page. This page is to be used to backup and archive all database content. <br><br>
            To backup the databases, a <b> beginning date </b> needs to be entered. <br><br>
            Next, an <b> ending date </b> needs to be entered. <br><br>
            Lastly, select the desired radio button to either backup or archive system data. <br><br>
            <b> Database Backup </b> will generate a .SQL file. This file will be located in C:\xampp\TSC-DB-backup.sql<br><br>
            <b> Archive </b> can be used for removing the following information from the app… <br>
            <ul> Old Tickets </ul>
            <ul> Deleted Technicians </ul>
            <ul> Old Ticket History </ul>
            <ul> Top Five Alternative Issues </ul><br>
            <b> Note this data can be recovered back into the application refer to User Manual</b>

        </div>
    </div>
</div><br>
<form action='Archive.php' method="post">
    <h3> Enter Beginning Date </h3> <input type="date" name= "beginDate" placeholder="MM-DD-YYYY" maxlength="20" required />
    <h3> Enter Ending Date</h3> <input type="date" name= "endDate" placeholder="MM-DD-YYYY" maxlength="20" required /><br><br>
    <div id="Maintenance">
        <h3> Please note all items must be archived before you can delete archived data. </h3>
        <div>
        <input type="radio" id="radio1" name="check_list[]" class="css3radio" value="back_up"><label class="toggler_r" for="radio1">Create Database Backup</label>
        <input type="radio" id="radio2" name="check_list[]" class="css3radio" value="arch_ticket"><label class="toggler_r" for="radio2">Archive Old Tickets</label>
        <input type="radio" id="radio3" name="check_list[]" class="css3radio" value="arch_ticket_history"><label class="toggler_r" for="radio3">Archive Old Ticket History</label>
        <input type="radio" id="radio4" name="check_list[]" class="css3radio" value="arch_tech"><label class="toggler_r" for="radio4">Archive Old Technicians</label>
        <input type="radio" id="radio5" name="check_list[]" class="css3radio" value="arch_TopFive"><label class="toggler_r" for="radio5">Archive Alternative Issues</label>
        </div>
        <br><br>
        <input class="submit" type="submit" value="Submit" name="submit"><br><br>
    </div>
</form>

<center><a href="#helpPOPUP"><button class="HELPbutton">Help</button></a></center>
</body>
</html>