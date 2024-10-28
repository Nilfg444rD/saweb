<?php
session_start();
session_destroy();  // Уничтожаем сессию
header('Location: admin.php');  // Перенаправляем обратно на страницу входа
exit();
