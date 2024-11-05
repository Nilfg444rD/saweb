<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'администратор') {
    header("Location: index.php"); // Перенаправление на страницу входа, если нет доступа
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Панель администратора</h1>
    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']); ?>! Это административная панель.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
