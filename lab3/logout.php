<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Перенаправление на страницу входа после выхода
exit();
?>
