<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'пользователь') {
    header("Location: index.php"); // Перенаправление на страницу входа, если нет доступа
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Page</title>
</head>
<body>
    <h1>Панель пользователя</h1>
    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']); ?>! Это пользовательская панель.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
