<?php
function connection() {
    // Подключение к базе данных
    $servername = "localhost"; // Сервер базы данных
    $username = "phpmyadmin"; // Имя пользователя
    $password = "toor"; // Пароль
    $dbname = "hackathon"; // Название базы данных

    // Создаем соединение
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Устанавливаем кодировку для корректного отображения данных
    $conn->set_charset("utf8");

    return $conn;
}
?>