<?php
session_start();

// Массив пользователей (логин и пароль)
$users = [
    'admin' => '123',  // Логин и пароль администратора (замени на свой правильный пароль)
];

// Если пользователь отправил форму
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка логина и пароля
    if (isset($users[$login]) && $users[$login] === $password) {
        // Сохраняем информацию о пользователе в сессии
        $_SESSION['user_id'] = $login;
    } else {
        // Выводим ошибку, если логин или пароль неверные
        $error = 'Введен невернй логин или пароль';
    }
}

// Если пользователь не авторизован, показываем форму входа
if (!isset($_SESSION['user_id'])) {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Вход для администратора</title>
    </head>
    <body>
        <h1>Вход для администратора</h1>
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" action="">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required><br><br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Войти</button>
        </form>
    </body>
    </html>
<?php
    exit(); // Останавливаем выполнение кода, чтобы не показывать админскую часть
}

// Если пользователь авторизован, показываем защищённый контент
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель Админа</title>
</head>
<body>
    <h1>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user_id']); ?>!</h1>
    
    <!-- Кнопка для выхода -->
    <form method="post" action="logout.php">
        <button type="submit">Выйти</button>
    </form>
</body>
</html>
