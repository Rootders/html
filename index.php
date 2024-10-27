<?php
session_start();
include "script/connection.php";

$conn = connection();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>дгту</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="header">
        <img class="logo" src="logo-contrast1.svg" alt="Logo">
        <a class="profile" href="#" id="auth-button">
            <span>
                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.13 11.164a1.465 1.465 0 0 0-.267 0 3.57 3.57 0 0 1-3.449-3.578C8.414 5.607 10.014 4 12 4a3.583 3.583 0 0 1 .13 7.164ZM7.958 14.144c-1.954 1.308-1.954 3.44 0 4.74 2.221 1.487 5.864 1.487 8.085 0 1.954-1.308 1.954-3.44 0-4.74-2.213-1.478-5.856-1.478-8.085 0Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
            <span id="auth-button-text" class="text"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Войти') ?></span>
        </a>
    </div>

    <div class="page">
        <div class="search_block">
            <form>
                <input type="text" name="text" class="search" placeholder="Поиск">
                <a class="submit">
                    <span>
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 56.966 56.966">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z" fill="#000000"></path>
                        </svg>
                    </span>
                </a>
                <span class="categories">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <g id="Line">
                            <rect height="12" rx="5" width="44" x="2" y="18" fill="#000000"></rect>
                            <rect height="12" rx="5" width="44" x="2" y="34" fill="#000000"></rect>
                            <rect height="12" rx="5" width="44" x="2" y="2" fill="#000000"></rect>
                        </g>
                    </svg>
                </span>
            </form>
        </div>
    </div>

    <main>
        <!-- Отображение товаров и избранного -->
        <?php
        // Получаем товары
        $sql = "SELECT p.id, p.name, p.created_at, f.user_id
                FROM products p
                LEFT JOIN favorites f ON p.id = f.product_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
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
                    <!-- Форма добавления в избранное -->
                    <form method="POST" action="">
                        <input type="hidden" name="favorite_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <button type="submit" class="add-product-button">Добавить в избранное</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p>Товары не найдены.</p>';
        }
        ?>
    </main>

    <!-- Modal for Login/Register -->
    <div id="auth-modal">
        <div class="modal-content">
            <span id="close-modal">&times;</span>
            <ul class="tab">
                <li><a href="#" id="login-tab" class="active">Вход</a></li>
                <li><a href="#" id="register-tab">Регистрация</a></li>
            </ul>
            <div id="login-form">
                <form action="script/login.php" method="POST">
                    <input type="text" name="login" placeholder="Имя пользователя" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <input type="submit" value="Войти">
                </form>
                <p>Нет аккаунта? <a href="#" id="show-register">Зарегистрироваться</a></p>
            </div>
            <div id="register-form" style="display: none;">
                <form action="script/register.php" method="POST">
                    <input type="text" name="login" placeholder="Имя пользователя" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <input type="submit" value="Зарегистрироваться">
                </form>
                <p>Уже есть аккаунт? <a href="#" id="show-login">Войти</a></p>
            </div>
        </div>
    </div>

    <script>
        const authButton = document.getElementById('auth-button');
        const authModal = document.getElementById('auth-modal');
        const closeModal = document.getElementById('close-modal');
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');

        authButton.addEventListener('click', () => {
            authModal.style.display = 'block';
        });

        closeModal.addEventListener('click', () => {
            authModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === authModal) {
                authModal.style.display = 'none';
            }
        });

        loginTab.addEventListener('click', () => {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
        });

        registerTab.addEventListener('click', () => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            registerTab.classList.add('active');
            loginTab.classList.remove('active');
        });

        showRegister.addEventListener('click', () => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        showLogin.addEventListener('click', () => {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });
    </script>
</body>
</html>
