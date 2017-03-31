<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="HelpButton.css">
<head>
    <title>UMSL Tech Support</title>
    <script type="text/javascript">
        //enables Other box when other is selected from drop down box
        function CheckOther(dropdownValueOther)
        {
            var element=document.getElementById('issue');
            if(dropdownValueOther=='Other'){
                element.style.display='inline-block'
            }
            else
                element.style.display='none';
        }
    </script>
</head>
<body>
<h1 align="center">Welcome to the Technology Support Center</h1>
<img src="images/umsl_type_white.gif" alt="UMSL" width="220" height="100" style="width:width:20px;height:84px;">
<form class="signin_form" action="CreateTicket.php" method="get" name="signin_form" "
    <div class="formHeader">
        <a href="index.php"><img id="dot" src="images/BLACK_DOT.gif" align="right" height="3px" width="3px"></a>
        <h2 align="center">Sign-in</h2>
    </div>
    <div class="FNbox">
        <!--Customer's firstname, lastname, and ssoid-->
        <input type="text" name="firstname" placeholder="First Name" maxlength="20" required /><br><br>
        <input type="text" name="lastname" placeholder="Last Name" maxlength="25" required /><br><br>
        <input type="text" name="ssoid" placeholder="SSO ID  (optional)" maxlength="15"/><br><br>
    </div>
    <div class="UserType">
        <!--Customer's campus role-->
        <select name="User" required><br><br>
            <?php
            $host="localhost";
            $user="root";
            $password="";
            $database="techinfo";
            $connect=mysqli_connect($host, $user, $password, $database);
            $sql = mysqli_query($connect,"SELECT UserType FROM user_type");
            $row_count = $sql->num_rows;
            echo "<option value=''>Type of User</option>";
            while ($row=mysqli_fetch_array($sql))
            {
                echo "<option value='".$row['UserType']."'>".$row['UserType']."</option>";
            }
            ?>
        </select><br><br>
    </div>
    <div class="TopFive">
        <!--Customer's problem selected from the drop down menu-->
        <select name="Current" id="Current" required onchange="CheckOther(this.value);"> <!--Current-->
                <?php
                $host="localhost";
                $user="root";
                $password="";
                $database="techinfo";
                $connect=mysqli_connect($host, $user, $password, $database);
                $sql = mysqli_query($connect,"SELECT Issue FROM topfive WHERE Selected = TRUE");
                $row_count = $sql->num_rows;
                echo "<option value=''>Current Issues</option>";
                while ($row=mysqli_fetch_array($sql))
                {
                    echo "<option value='".$row['Issue']."'>".$row['Issue']."</option>";
                }
                    echo "<option value='Other'>Other</option>";
                ?>
        </select><br><br>
        <input type="text" name="issue" id="issue" placeholder="Short Description" maxlength="75"  style="display:none;"/><br><br>
    </div>
    <button class="submit" type="submit">Submit</button>
    <br><br><br>
    <div class="box">
        <!--<a href="#helpPOPUP"><img src="images/question.png." alt="question" width="35" height="35" style="center"></a>-->
        <center><a href="#helpPOPUP"><button class="HELPbutton" type="button">Help</button></a></center>
    </div>
    <div id="helpPOPUP" class="overlay">
        <div class="popup">
            <h2>Help</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                This page is used to sign-in to receive walk-in help from one of our technicians.
                <br> <br>
                Please fill out the form on this page with your First Name, Last Name, SSO ID if you know your ID, what type of user you are (Student, Faculty, Staff) and the issue you are experiencing.
                <br><br>
                If the issue you are experiencing is not in the dropdown list please select ‘other’ and a new textbox will appear. Please fill in a short description of the issue you are experiencing.
                <br><br>
                Press submit after you have completed the form and you will be added to the queue.
            </div>
        </div>
    </div>
</form>
</body>
</html>