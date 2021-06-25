<?php
require_once "checkLogin.php";
$hostname = "localhost";
$user = "root";
$password = "";
$database = "site";
$connection = mysqli_connect($hostname, $user, $password, $database);
mysqli_set_charset($connection,"utf8");
 
if(!$connection){
    print "<p class='text' class='colorRed'>Falha na conexão com banco de dados.</p>";
}
if($_SERVER['REQUEST_URI'] == "admin/connection.php"){
	header("location: /index.php");
}