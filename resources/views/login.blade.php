<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/signin.css">
    <link rel="stylesheet" href="/css/login.css">
    <script src="/js/login.js" defer></script>
</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo">
    </header>

    <div class="background">
        <div class="login-form">
            <h2 class="form-title">Войти</h2>
            <form action="#" id="login">
                @csrf
                <!-- Поле для почты -->
                <input type="email" name="email" class="form-input" placeholder="почта" required>

                <!-- Поле для пароля -->
                <input type="password" name="password" class="form-input" placeholder="пароль" required>

                <!-- Кнопка регистрации -->
                <button type="submit" class="form-button">Войти</button>
            </form>
            <p class="form-footer">
                Нет аккаунта?<a href="/signin">Зарегистрируйтесь здесь</a> <br>
                {{-- <a href="change password.html">Забыли пароль?</a> --}}
            </p>
        </div>
    </div>

</body>

</html>