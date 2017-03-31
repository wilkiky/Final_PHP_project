<?php
    //forces a user to be logged into the application before accessing this page
session_start();
if ($_SESSION['role']!="Admin")
{
    header("Location: index.php");
}

function printAlert($text)
{
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'EditUser.php';
            </script>";
    die();
}

//server information
$host="localhost";
$user="root";
$password="";
$database="techinfo";

?>

<html>
<link rel="stylesheet" type="text/css" href="EU.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">
    <head>
        <title>Edit Users</title>
    </head>
    <script type="text/javascript">
        function openTab(evt, tabName)
        {
            // Declare all variables
            var i, tabcontent, tablinks;
            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            // Show the current tab, and add an "active" class to the link that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

    </script>
    <body>
        <h1 align="center">Edit User Panel</h1>
        <center><input class="EUsubmit" type="button" value="Control Panel" onClick="window.location.href='AdminPanel.php'">
            <div class="box">
                <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
        </center>
        <div id="helpPOPUP" class="overlay" align="center">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    This page allows an admin to create a new user, set new user password, set a new user role, delete user, and restore previous users of the system.
                    <br><br>
                    <b>Create New User</b> - This tab allows the admin to enter new users into the system. This is to be used when a new employee needs access to the system. Pressing create tech will place the tech into the system.
                    <br><br>
                    <b>Set New User Password</b> - This tab allows the admin to change a current system user’s password by selecting a specific user, then allowing them to change their password. Pressing set password will reassign that user a new password.
                    <br><br>
                    <b>Set User Role</b> - This tab allows the admin to change the role of a current user in the system. The admin would select the tech from a dropdown list and then select the new role they want to give to the tech. Pressing update tech will reassign the techs role
                    <br><br>
                    <b>Delete a User</b> - This tab allows the admin to delete a user of the system. The admin would select the user from the dropdown menu then select delete tech to remove that user.
                    <br><br>
                    <b>Restore Previous User</b> - This tab allows the admin to restore a previously deleted tech from the system. From the dropdown select the deleted tech and press re-enable tech to restore the user.
                    <br><br>
                    Pressing control panel on the top of the screen will return the user back to the Admin Control Panel.
                </div>
            </div>
        </div>
        <br>
        <ul class="tab">
            <li><a href="#" class="tablinks" onclick="openTab(event, 'CreateUser')">Create New User</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'SetPassword')">Set New User Password</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'SetRole')">Set User Role</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'DeleteUser')">Delete User</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'RestoreUser')">Restore Previous User</a></li>
        </ul>
        <div id="CreateUser" class="tabcontent">
            <h3>Create a New User</h3>
            <p>Use this page to create a new user into the system.</p>
            <form method="get" action="CreateTech.php">
                <!--Creating a New technician-->
                <input type="text" name="FName" placeholder="Enter First Name" maxlength="25" required><br><br>
                <input type="text" name="LName" placeholder="Enter Last Name" maxlength="25" required><br><br>
                <input type="email" name="email" placeholder="Enter E-Mail Address" maxlength="50" required><br><br>
                <input type="text" name="username" placeholder="Enter Username" maxlength="25" required><br><br>
                <input type="password" name="password" placeholder="Enter Password" maxlength="25" required><br><br>
                <div class="SetUserRole">
                    <select name='Role' required >
                    <?php
                        //Populates dropdown for all possible roles
                        $connect=mysqli_connect($host, $user, $password, $database);
                        //$sql = mysqli_query($connect, "SELECT * FROM roles");
                        $sql = mysqli_query($connect, "SELECT role from roles");
                    echo "<option value=''>Select User Role:</option>";
                        while ($row = mysqli_fetch_assoc($sql))
                        {
                            echo "<option value='".$row['role']."'>".$row['role']."</option>";
                        }
                            echo "</select>";
                        ?>
                </div><br><br>
                <button class="submit" type="submit" >Create Tech</button>
            </form>
        </div>
        <div id="SetPassword" class="tabcontent">
            <h3>Set a User Password</h3>
            <p>User this page to set a new User Password</p>
            <form method="get" action="ChangePassword.php">
                <div class="SelectUser">
                    <select name="User" required >
                        <!--PHP code below populates current technicians dropdown box-->
                        <?php
                        $connect=mysqli_connect($host, $user, $password, $database);
                        $sql = mysqli_query($connect, "SELECT * FROM technicians where end_date IS NULL AND username != 'PENDING'");
                        echo "<option value=''>Technicians</option>";
                        while ($row = mysqli_fetch_array($sql))
                        {
                            echo "<option value='".$row['username']."'>".$row['username']."</option>";
                        }
                        echo "</select>";
                        ?>
                </div><br>
                <input type="password" name="password" placeholder="Enter New Password" maxlength="25" required><br><br>
                <button class="submit" type="submit">Set Password</button>
            </form>
        </div>
        <div id="SetRole" class="tabcontent">
            <h3>Change a User Role</h3>
            <p>This page allows to promote or demote a user role in the system.</p>
            <form method="get" action="TechChangeRole.php">
                <div class="SelectUser">
                    <select name="User" required>
                        <!--PHP code below populates current technicians dropdown box-->
                        <?php
                        $connect=mysqli_connect($host, $user, $password, $database);
                        $sql = mysqli_query($connect, "SELECT * FROM technicians where end_date IS NULL AND username != 'PENDING'");
                        echo "<option value=''>Technicians</option>";
                        while ($row = mysqli_fetch_array($sql))
                        {
                            echo "<option value='".$row['username']."'>".$row['username']."</option>";
                        }
                        echo "</select>";
                        ?><br><br>
                        <div class="SetUserRole">
                            <select name='Role' required >
                                <?php
                                //Populates dropdown for all possible roles
                                $connect=mysqli_connect($host, $user, $password, $database);
                                $sql = mysqli_query($connect, "SELECT role from roles");
                                echo "<option value=''>Select User Role:</option>";
                                while ($row = mysqli_fetch_assoc($sql))
                                {
                                    echo "<option value='".$row['role']."'>".$row['role']."</option>";
                                }
                                echo "</select>";
                                ?>
                        </div><br><br>
                        <button class="submit" type="submit">Update Tech</button>
                </div>
            </form>
        </div>
        <div id="DeleteUser" class="tabcontent">
            <h3>Delete a User</h3>
            <p>This page allows an Admin to remove a user from the system.</p>
            <form method="get" action="DeleteTech.php">
                <div class="DeleteUser">
                    <select name="User" required>
                        <!--PHP code below populates current technicians dropdown box-->
                        <?php
                        $connect=mysqli_connect($host, $user, $password, $database);
                        $sql = mysqli_query($connect, "SELECT * FROM technicians where end_date IS NULL AND username != 'PENDING'");
                        echo "<option value=''>Technicians</option>";
                        while ($row = mysqli_fetch_array($sql))
                        {
                            echo "<option value='".$row['username']."'>".$row['username']."</option>";
                        }
                        echo "</select>";
                        ?><br><br>
                </div><br>
                <button class="submit" type="submit">Delete Tech</button>
            </form>
        </div>
        <div id="RestoreUser" class="tabcontent">
            <h3>Restore a Previously Deleted User </h3>
            <p>This page allows Admin to restore a deleted users from the system.</p>
            <form method="get" action="ReEnableTech.php">
                <div class="ReEnableDDbox">
                    <select name="User" required>
                        <!--PHP code below populates current technicians dropdown box-->
                        <?php
                        $connect=mysqli_connect($host, $user, $password, $database);
                        $sql = mysqli_query($connect, "SELECT * FROM technicians where end_date IS NOT NULL AND username != 'PENDING'");
                        echo "<option value=''>Technicians</option>";
                        while ($row = mysqli_fetch_array($sql))
                        {
                            echo "<option value='".$row['username']."'>".$row['username']."</option>";
                        }
                        echo "</select>";
                        ?>
                </div><br>
                <button class="submit" type="submit">Re-Enable Tech</button>
            </form>
        </div>
    <br>
        <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
    </body>
</html>