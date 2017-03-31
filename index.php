<?php
session_start();
?>
<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="form.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">
<head>
    <title>HOME</title>
</head>

<body>
<h1 align="center">Welcome to the Technology Support Center</h1>
<img src="images/umsl_type_white.gif" alt="UMSL" width="220" height="100" style="width:200px;height:84px;">
<br>
<form class="signin_form" id='login' action='Login.php' method='GET'>            <!--would be good to get method='POST' better -->
    <div class="formHeader">
        <h2 align="center">Sign-in</h2>
    </div>
    <div class="LIbox">
        <input type="text" name="username" placeholder="Username" maxlength="25" required /><br><br>
        <input type="password" name="password" placeholder="Password" maxlength="25" required /><br><br>
        <button class="submit" type="submit" >Login</button><br><br>
        <button class="submit" type="button" onclick="window.location.href='CustomerLogin.php'">Customer Sign-In
        </button>
<br><br>
        <div class="box">
            <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
        </div>

        <div id="helpPOPUP" class="overlay">
            <div class="popup">
                <h2>Help</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                    Username is a required field.  If you do not have a username please see one of the helpdesk Administrators.
                    <br><br>
                    Password is a required field. If you have forgotten your password please see the helpdesk Administrator.
                    <br><br>
                    If you are an administrator and are having difficulties logging on please refer to your User Manual.
                </div>
            </div>
        </div>
        <?php
        $reasons="";
        $reasons = array("1" => "Wrong Username or Password");
        if (isset($_GET["loginFailed"]))
            echo $reasons[$_GET["reason"]];

        ?>
    </div>
    <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
</form>
</body>
</html>