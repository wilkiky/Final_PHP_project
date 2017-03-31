<?php
//Variables from TopFive.php
$Top5 = $_GET['NewEntry'];
if ($Top5 == "") {
    printAlert("Entry cannot be blank.");
}
else {
    //Server Connection
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "techinfo";
    //Connect to Server
    $connect = mysqli_connect($host, $user, $password, $database);
    //If unable to connect to server
    if (!$connect) {
        die("Connection Failed");
    }
    //acceptable input can only be capital or lower case letters, numbers, spaces and hypens
    if (preg_match('/^[a-z0-9 -]+$/i', $Top5)){
        //Insert into database
        $sql = "INSERT INTO techinfo.topfive (Issue,Selected) VALUES ('$Top5',False)";
        if ($connect->query($sql) === TRUE) {
            //if data is added successfully
            printAlert($Top5 . " has been added to the Alternate Issues dropdown");
        } else {
            //if data entry fails
            echo "Error updating record: " . $connect->error;
        }
        $connect->close();
        //when completed, go to TopFive.php
        header("Location: TopFive.php");
    }
    //if unaccepted special charicters are entered error and re-rout
    else{
        //Newentry cannot have numbers or characters
        printAlert("Create Alternate Issue can only accept letters, numbers, and hyphens.  Please remove the special characters.");
    }
}
//Error Alert Function
function printAlert($text){
    echo "<script language='javascript'>
            alert('$text');
            window.location.href = 'TopFive.php';
            </script>";
    die();
}

?>