<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "123";
$dbname = "saweb1";

// Создаем соединение
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Проверяем соединение
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
    // Если нашли пользователя
    $row = $result->fetch_assoc();
    if ($row['login'] === 'admin') {
        echo "Добро пожаловать, администратор!";
    } else {
        echo "Добро пожаловать, пользователь!";
    }
} else {
    echo "Неверные учетные данные!";
}

$stmt->close();
$conn->close();
?>
