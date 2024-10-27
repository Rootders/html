<?php
function connection(){
session_start();
$host = 'localhost';
$user = 'phpmyadmin';
$pass = 'toor';

$link = mysqli_connect($host, $user, $pass);

mysqli_select_db($link, 'phpmyadmin');

if(!$link){
    die('Error connect to DataBase');
}
return $link;
}
?>
