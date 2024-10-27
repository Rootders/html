<?php
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

// SQL-запрос для получения данных о товарах и информации об избранном
$sql = "
    SELECT p.id, p.name, p.created_at, f.user_id
    FROM products p
    LEFT JOIN favorites f ON p.id = f.product_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
    <style>
        /* Стили для сетки товаров */
        main {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-name {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-date, .product-user {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<main>
    <?php
    // Проверяем, есть ли результаты
    if ($result->num_rows > 0) {
        // Выводим данные о каждом товаре
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="product-card">
                <h2 class="product-name"><?php echo htmlspecialchars($row['name']); ?></h2>
                <p class="product-date">Дата создания: <?php echo date("d.m.Y", strtotime($row['created_at'])); ?></p>
                <?php if ($row['user_id']) { ?>
                    <p class="product-user">Добавил в избранное: Пользователь <?php echo htmlspecialchars($row['user_id']); ?></p>
                <?php } else { ?>
                    <p class="product-user">Товар не в избранном</p>
                <?php } ?>
            </div>
            <?php
        }
    } else {
        echo "Товары не найдены.";
    }

    // Закрываем соединение
    $conn->close();
    ?>
</main>

</body>
</html>

