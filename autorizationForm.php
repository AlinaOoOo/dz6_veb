<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в аккаунт</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h1>Вход</h1>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="error">Неверный логин или пароль</div>
    <?php endif; ?>
    
    <form method="POST" action="autorization.php">
        <div class="field-group">
            <label>Логин</label>
            <input type="text" name="login" required>
        </div>
        
        <div class="field-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit">Войти</button>
    </form>
    
    <div class="links">
        <a href="index.php">Нет аккаунта? Зарегистрироваться</a>
    </div>
</div>

</body>
</html>