<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/signin.css">
    <link rel="stylesheet" href="/css/login.css">
    <script src="/js/signin.js" defer></script>

</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo">
    </header>

    <div class="background">
        <div class="signin-form">
            <h2 class="form-title">Регистрация</h2>
            <form class="signin" id="signin">
                @csrf
                <!-- Поле для имени -->
                <input type="text" name="name" class="form-input" placeholder="имя" required>

                <!-- Поле для почты -->
                <input type="email" name="email" class="form-input" placeholder="почта" required>

                <!-- Поле для пароля -->
                <input type="password" name="password" class="form-input" placeholder="пароль" required>

                <!-- Чекбокс -->
                <div class="form-checkbox">
                    <input type="checkbox" id="agreement" name="agreement" required>
                    <label for="agreement">Согласие на обработку персональных данных</label>
                </div>

                <!-- Кнопка регистрации -->
                <button type="submit" class="form-button">зарегистрироваться</button>
            </form>
            <p class="form-footer">
                Есть аккаунт? <a href="/login">Войти</a>
            </p>
        </div>
    </div>

</body>

</html>