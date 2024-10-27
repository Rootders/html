<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Если форма добавления товара отправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['name'];
    $created_at = date("Y-m-d H:i:s");

    // SQL-запрос для добавления товара
    $stmt = $conn->prepare("INSERT INTO products (name, created_at) VALUES (?, ?)");
    $stmt->bind_param("ss", $product_name, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Товар успешно добавлен');</script>";
    } else {
        echo "<script>alert('Ошибка при добавлении товара');</script>";
    }

    $stmt->close();
}

// SQL-запрос для получения данных товаров и избранного
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

        .add-product-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-product-button:hover {
            background-color: #0056b3;
        }

        /* Стили для модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .modal input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<main>
    <?php
    // Проверяем, если есть результаты
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
        echo '<div class="product-card">';
        echo '<h2>Товары не найдены</h2>';
        echo '<p>Вы можете добавить новый товар.</p>';
        echo '<button class="add-product-button" onclick="openModal()">Добавить товар</button>';
        echo '</div>';
    }

    // Закрываем соединение
    $conn->close();
    ?>
</main>

<!-- Модальное окно для добавления товара -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Добавить товар</h2>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Введите название товара" required>
            <input type="submit" value="Добавить">
        </form>
    </div>
</div>

<script>
// Открыть модальное окно
function openModal() {
    document.getElementById('addProductModal').style.display = 'block';
}

// Закрыть модальное окно
function closeModal() {
    document.getElementById('addProductModal').style.display = 'none';
}

// Закрыть модальное окно при нажатии вне его
window.onclick = function(event) {
    if (event.target == document.getElementById('addProductModal')) {
        closeModal();
    }
}
</script>

</body>
</html>

