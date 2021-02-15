<?php  

$dbHost = "localhost" ;
$dbName = "school";
$dbUsername = "root" ;
$dbPass = "";

$mySqli_con = mysqli_connect($dbHost, $dbUsername, $dbPass, $dbName);

if(!$mySqli_con){
    echo "Connection Error";
}

?>