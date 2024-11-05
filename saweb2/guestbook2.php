<?php
// Подключение к базе данных MySQL
$host = 'localhost';
$user = 'root'; // Убедись, что этот пользователь совпадает с твоими настройками MySQL
$password = '123'; // Вставь свой пароль, если он есть
$dbname = 'guest';

// Подключение к базе данных
$conn = new mysqli($host, $user, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Если форма была отправлена, сохраняем данные
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
    $text_message = htmlspecialchars($_POST['text_message'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $datetime = date("Y-m-d H:i:s");

    // Подготовка запроса для предотвращения SQL-инъекций
    $stmt = $conn->prepare("INSERT INTO guest (user, text_message, e_mail, data_time_message) VALUES (?, ?, ?, ?)");

    // Проверка подготовки запроса
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
    // Защищаем вывод данных с помощью htmlspecialchars()
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8') . ":</strong> " . htmlspecialchars($row['text_message'], ENT_QUOTES, 'UTF-8') . " (" . $row['data_time_message'] . ")</p>";
        }
    } else {
        echo "Сообщений пока нет.";
    }
    ?>
</body>
</html>
