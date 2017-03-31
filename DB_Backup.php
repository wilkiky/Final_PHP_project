<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$name = 'techinfo';
$tables = '*';
    //backup_tables('localhost', 'root', '', 'techinfo', 'tables');
    backup_tables('localhost','root', '', 'techinfo');

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

    //$connect = mysqli_connect($host,$user,$pass);
    $connect = mysqli_connect($host, $user, $pass, $name);
    mysqli_select_db($connect, $name);

    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($connect, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    $return = null;
    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($connect, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($connect,'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j < $num_fields; $j++)
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_ireplace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j < ($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
    //file = fopen("ftp://user:password@example.com/test.txt","w");
    $handle = fopen('C:\xampp\TSC-DB-backup.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
    header("Location: TylerBackup.php");
}

?>