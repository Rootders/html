<?php
session_start();
$host = 'localhost';
$user = 'phpmyadmin';
$pass = 'toor';

$link = mysqli_connect($host, $user, $pass);

mysqli_select_db($link, 'phpmyadmin');

if(!$link){
    die('Error connect to DataBase');
}

$login = $_POST['login'];
$password = $_POST['password'];

$check_user = "SELECT * FROM users WHERE `login` = '$login' AND `password` = '$password'";
$result = mysqli_query($link, $check_user);

if (mysqli_num_rows($result)>0){
    $user = mysqli_fetch_assoc($result);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "name" => $user['name'],
        "login" => $user['login'],
        "trackable_goods" => $user['trackable_goods']
    ];

    header('Location: index.php');

} else {
    echo "Неверные учетные данные.";
}


?>
