<?php
function login($login, $password){
    
connection();

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

} else {
    echo "Неверные учетные данные.";
}

}
?>
