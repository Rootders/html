<?php
session_start();
include "connection.php";

$conn = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Поиск пользователя
    $sql = "SELECT * FROM users WHERE login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Проверка пароля (предполагается, что пароль хэширован)
        if (password_verify($password, $user['password'])) {
            // Успешный вход
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['login']
            ];
            header("Location: ../index.php");
            exit();
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}
?>