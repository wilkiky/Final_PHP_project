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
<script>
    function validateForm() {
        var x = document.forms["topFive"]["NewEntry"].value;
        if (x == ""){
            alert("Enter new Issue");

        }

    }
</script>
    <head>
        <title>Edit Users</title>
    </head>
    <body>
        <h1 align="center">Edit Top Five Issues</h1>
        <center>
            <input class="EUsubmit" type="button" value="Control Panel" onClick="window.location.href='AdminPanel.php'">
            <div class="box">
                <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
        </center>
        </div>
        <div id="helpPOPUP" class="overlay" align="center">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    This page allows an admin to replace the top five presented issues to the customers on the sign-in sheet.
                    <br><br>
                    Please note that only Five issues can be enabled at once.
                    <br><br>
                    <b>Remove Current Issue</b> - This section allows the admin to remove the current issues from the dropdown seen by the customers. This is done by selecting the issue from the dropdown and pressing remove issue button.
                    <br><br>
                    <b>Re-Enable Issue</b> - This section allows the admin to re-enable a previous issue from the dropdown seen by the customers. This is done by selecting the issue from the dropdown and pressing re-enable issue button.
                    <br><br>
                    <b>Add New Issue</b> - This section allows the admin to add new issues to select from the dropdown seen by the customers. This is done by entering the type of issue into the textbox and then pressing add new issue button. After that is complete the issue will then populate in the re-enable issue dropdown. The new issue when then need to be enabled to show up to customers.
                    <br><br>
                    Pressing control panel on the top of the screen will return the user back to the Admin Control Panel.
                </div>
            </div>
        </div>

        <form method="get" action="DeleteTop5.php">
            <div class="Current">

                <table id="T1" cellspacing="15">
                    <tr>
                        <th>Remove Current Issue:</th>
                        <th><select name="Current">
                                <!--populates top five issues dropdown box-->
                                <?php
                                $host="localhost";
                                $user="root";
                                $password="";
                                $database="techinfo";
                                $connect=mysqli_connect($host, $user, $password, $database);
                                $current = mysqli_query($connect,"SELECT Issue FROM topfive WHERE Selected = TRUE AND Issue != 'Other'");
                                $row_count = $current->num_rows;
                                echo "<option value=''>Current Issues</option>";
                                while ($row=mysqli_fetch_array($current))
                                {
                                    echo "<option value='".$row['Issue']."'>".$row['Issue']."</option>";
                                }
                                ?>
                            </select></th>
            </div>
                        <th><input class="EUsubmit" type="submit" value="Remove Issue"></th>
        </form>
            <form method="get" action="ReEnableTop5.php">
                <div class="Old">
                    <tr>
                        <th>Re-Enable Issue:</th>
                        <th><select name="Old" >
                                <?php
                                $host="localhost";
                                $user="root";
                                $password="";
                                $database="techinfo";
                                $connect=mysqli_connect($host, $user, $password, $database);
                                $old = mysqli_query($connect,"SELECT Issue FROM topfive WHERE Selected = FALSE AND Issue != 'Other'");
                                echo "<option value=''>Alternate Issues</option>";while ($row=mysqli_fetch_array($old))
                                {
                                    echo "<option value='".$row['Issue']."'>".$row['Issue']."</option>";
                                }
                                ?>
                            </select></th>

                </div>
                    <th><input class="EUsubmit" type="submit" value="Re-Enable Issue"</th>
            </form>

        <form name="topFive" method="get" action="CreateTop5.php" onsubmit="return validateForm()">
              <div class="New">
                  <tr>
                      <th>Add New Issue:</th>
                      <th><input type="text" name="NewEntry" placeholder="New Dropdown Issue" maxlength="25">
                      <th><input class="EUsubmit" type="submit" value="Add New Issue"></th>
              </div>
        </form>
        </table>
    <br>
        <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
    </body>
</html>

<!--$comment=strip_tags(value);
    session_set_cookie_parms();-->