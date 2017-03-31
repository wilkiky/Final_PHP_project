<?php
$host="localhost";
$user="root";
$password="";
$database="techinfo";
$connect = mysqli_connect($host,$user,$password,$database);
$connect = mysqli_connect($host, $user, $password, $database);
$Top5 = 'Testing it out';

$result =  (preg_match('^[a-z0-9-]+$/i', $Top5));
if ($result == NULL) {
   echo "Connection failed: ";
}
else {
    echo "Connected successfully";
}