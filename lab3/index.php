<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <script>
        function validateForm() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const regex = /^[A-Za-z0-9]{4,20}$/;

            if (!regex.test(username)) {
                alert("Логин должен содержать только буквы и цифры (4-20 символов).");
                return false;
            }
            if (!regex.test(password)) {
                alert("Пароль должен содержать только буквы и цифры (4-20 символов).");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <form action="login.php" method="post" onsubmit="return validateForm();">
        <label for="username">Логин:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
