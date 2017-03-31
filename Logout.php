    <!--
    index.php
    -->
<?PHP
session_start();
$host="localhost";
$user="root";
$password="";
$database="techinfo";

$TechName = $_SESSION['username'];

$connect = mysqli_connect($host,$user,$password,$database);
if(!$connect){
    die("Connection Failed");
}

$sql = "UPDATE technicians SET available = FALSE WHERE username = '$TechName'";
if ($connect->query($sql) === TRUE)
{
    echo "Record updated successfully";
}
else
{
    echo "Error updating record: " . $connect->error;
}

session_destroy();
header("Location: index.php")
?>