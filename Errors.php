<?php
session_start();
if ($_SESSION['role']!='StaffTech')
{
    if ($_SESSION['role']!='StudentTech')
    {
        if ($_SESSION['role'] !='Admin')
        {
            header("Location: index.php");
        }
    }
}
$error = $_GET['error'];
echo $error;
if ($error == 1)
{
    echo "That ticket has been closed by anotoher tech";
    if ($_SESSION['role'] == 'Admin')
    {
//        header("Location: AdminPanel.php");
    }
    elseif ($_SESSION['role'] == 'Viewer')
    {
        header("Location: ViewerApp.php");
    }
    else
    {
        header("Location: Queue.php");
    }
}
else{
    echo "You Failed!!!";
}