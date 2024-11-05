<?php
session_start();

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "123";
$dbname = "saweb1";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем и фильтруем данные
$user = $_POST['username'];
$pass = $_POST['password'];

// Проверка на соответствие формату с помощью регулярного выражения
if (!preg_match("/^[A-Za-z0-9]{4,20}$/", $user) || !preg_match("/^[A-Za-z0-9]{4,20}$/", $pass)) {
    die("Неверный формат логина или пароля.");
}

// Используем подготовленные выражения для предотвращения SQL-инъекций
$stmt = $conn->prepare("SELECT * FROM user WHERE login = ? AND password = ?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Устанавливаем сессии пользователя
    $_SESSION['username'] = $row['login'];
    $_SESSION['role'] = $row['role'];

    // Перенаправляем в зависимости от роли
    if ($row['role'] === 'администратор') {
        header("Location: admin.php");
    } else {
        header("Location: user.php");
    }
    exit();
} else {
    echo "Неверные учетные данные!";
}

$stmt->close();
$conn->close();
?>
