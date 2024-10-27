<?php
	include "script/connection.php";
        session_start();
		connection();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>дгту</title>
	<link rel="stylesheet" type="text/css" href="css-main.css">
</head>
<body>
	<div class="header">
		<img class="logo" src="logo-contrast.svg">
		<a class = "profile" href="#">
      <span><svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.13 11.164a1.465 1.465 0 0 0-.267 0 3.57 3.57 0 0 1-3.449-3.578C8.414 5.607 10.014 4 12 4a3.583 3.583 0 0 1 .13 7.164ZM7.958 14.144c-1.954 1.308-1.954 3.44 0 4.74 2.221 1.487 5.864 1.487 8.085 0 1.954-1.308 1.954-3.44 0-4.74-2.213-1.478-5.856-1.478-8.085 0Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>
      <span id="auth-button" class= "text"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
    </a>
	</div>
	<div class="page">
      	<div class="search_block">
  			<form>
    			<input type="text" name="text" class="search" placeholder="Поиск">
				<a class="submit" >
				<span >
    			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"><path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23 s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92 c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17 s-17-7.626-17-17S14.61,6,23.984,6z" fill="#000000" style="fill: rgb(128, 128, 128);"></path></svg>
				</span>
				</a>
				<span class="categories">
				<svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><g id="Line"><rect height="12" rx="5" width="44" x="2" y="18" fill="#000000" style="fill: rgb(128, 128, 128);"></rect><rect height="12" rx="5" width="44" x="2" y="34" fill="#000000" style="fill: rgb(128, 128, 128);"></rect><rect height="12" rx="5" width="44" x="2" y="2" fill="#000000" style="fill: rgb(128, 128, 128);"></rect></g></svg>
				</span>
			</form>
		</div>
	</div>
	<main>

	
	<div id="login-modal">
	<form action="script/login.php" method="POST">
        <input type="text" name="login" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Войти">
        <button type="button"  id="close-modal">Закрыть</button>
    </form>
</div>

<script>
    const authButton = document.getElementById('auth-button');
    const loginModal = document.getElementById('login-modal');
    const closeModal = document.getElementById('close-modal');

    authButton.addEventListener('click', () => {
        loginModal.style.display = 'block';
    });

    closeModal.addEventListener('click', () => {
        loginModal.style.display = 'none';
    });
</script>
	</main>	
</body>
</html>