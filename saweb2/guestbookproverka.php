<?php
// Подключение к базе данных MySQL
$host = 'localhost';
$user = 'root';
$password = '123';
$dbname = 'guest';

$conn = new mysqli($host, $user, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Функция для очистки данных и предотвращения XSS
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Если форма была отправлена, сохраняем данные
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Очистка входных данных
    $user = sanitize($_POST['user']);
    $text_message = sanitize($_POST['text_message']);
    $email = sanitize($_POST['email']);
    $datetime = date("Y-m-d H:i:s");

    // Подготовка запроса для предотвращения SQL-инъекций
    $stmt = $conn->prepare("INSERT INTO guest (user, text_message, e_mail, data_time_message) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("ssss", $user, $text_message, $email, $datetime);

    // Выполнение запроса
    if (!$stmt->execute()) {
        echo "Ошибка: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

// Извлечение всех сообщений из таблицы
$result = $conn->query("SELECT * FROM guest");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Гостевая книга</h1>

    <form method="post">
        <label for="user">Имя:</label>
        <input type="text" id="user" name="user" required><br><br>

        <label for="text_message">Сообщение:</label>
        <textarea id="text_message" name="text_message" required></textarea><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Отправить">
    </form>

    <h2>Сообщения:</h2>
    <?php
    // Защищенный вывод сообщений
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8') . ":</strong> ";
            echo htmlspecialchars($row['text_message'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($row['data_time_message'], ENT_QUOTES, 'UTF-8') . ")</p>";
        }
    } else {
        echo "Сообщений пока нет.";
    }
    $conn->close();
    ?>
</body>
</html>
