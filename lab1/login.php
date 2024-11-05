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

$user = $_POST['username'];
$pass = $_POST['password'];

// Обрати внимание на имя таблицы и поля
$sql = "SELECT * FROM user WHERE login = '$user' AND password = '$pass'";
$result = $conn->query($sql);

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
$conn->close();
?>
