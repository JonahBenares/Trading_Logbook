<?php
//include 'functions/functions.php';
backup_tables('localhost','root','','db_trading');


$host='localhost';
$user='root';
$pass='';
$name='db_trading';
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

$link = mysql_connect($host,$user,$pass);
mysql_select_db($name,$link);


if($tables == '*')
{
$tables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result))
{
$tables[] = $row[0];
//echo $row[0]."<br>";
}
}
else
{
$tables = is_array($tables) ? $tables : explode(',',$tables);
}
foreach($tables as $table)
{
  
$result = mysql_query("SELECT * FROM `".$table."`");
$num_fields = mysql_num_fields($result);

$row2 = mysql_fetch_row(mysql_query("SHOW CREATE TABLE `".$table."`"));
$return.= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++)
{
while($row = mysql_fetch_row($result))
{
$return.= 'INSERT INTO `'.$table.'` VALUES(';
for($j=0; $j<$num_fields; $j++)
{
$row[$j] = addslashes($row[$j]);
if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
if ($j<($num_fields-1)) { $return.= ','; }
}
$return.= ");\n";
}
}
$return.="\n\n\n";
}


$data=date("m_d_Y_His").'.sql';
$handle = fopen('Back-up/db_backup/'.$data,'w+');

fwrite($handle,$return);


$copysql='Back-up/db_backup/'.$data;
/*rcopy($copysql , "C:\Users\Jonah\Dropbox\/".$data);*/
rcopy($copysql , "C:\Onedrive_link\/trading_logbook_backup\/db_backup\/".$data);
fclose($handle);
}


// Function to remove folders and files 
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files       
    function rcopy($src, $dst) {
        //if (file_exists ( $dst ))
           // rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }
?>