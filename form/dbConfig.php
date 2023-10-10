<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "blog";
 
$con = mysqli_connect($server, $user, $password, $dbname);


if(!$con){
    die("Connection Faild" . mysqli_connect_error());
}

?>

