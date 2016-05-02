<?php
// Connect to your MySQL database.
$hostname = ""; // localhost if on the same server otherwise something like this mysql51.websupport.sk
$username = ""; // db username 
$password = ""; // db password
$database = ""; // dn name
$port = 3309;   // port number


$link = mysqli_connect($hostname, $username, $password, $database, $port);


if (!$link) {
die('Connection failed: ' . mysql_error());
}
else{
     echo "Connection to MySQL server " .$hostname . " successful!
" . PHP_EOL;
}

$db_selected = mysqli_select_db($link,$database);
if (!$db_selected) {
    die ('Can\'t select database: ' . mysqli_error($link));
}
else {
    echo 'Database ' . $database . ' successfully selected!';
}



$find = "";  //insert string to find
$replace = "";  //insert string to replace

$loop = mysqli_query($link,"
    SELECT
        concat('UPDATE ',table_schema,'.',table_name, ' SET ',column_name, '=replace(',column_name,', ''{$find}'', ''{$replace}'');') AS s
    FROM
        information_schema.columns
    WHERE
        table_schema = '{$database}'")
or die ('Cant loop through dbfields: ' . mysqli_error($link));

while ($query = mysqli_fetch_assoc($loop))
{
        mysqli_query($link,$query['s']);
}
mysqli_close($link);
?>