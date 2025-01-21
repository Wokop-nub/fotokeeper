<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotokeeper</title>
    <link rel="stylesheet" href="/css/slider.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="slider">
        <header class="header">
            <img src="/img/logo.svg" alt="logo">
        </header>
        <div class="main">
            <h1>Можно не платить<br></h1>
            <h3>С нами вам не о чем переживать.<br>Храните фотографии бесплатно</h3>
        </div>
        <div class="slide active" style="background-image: url('/img/photo1.png');"></div>
        {{-- <div class="slide" style="background-image: url('/img/photo5.jpg');"></div> --}}
        <div class="slide" style="background-image: url('/img/photo6.jpg');"></div>
        <div class="slide" style="background-image: url('/img/photo7.jpg');"></div>
    </div>
    <button class="start"><a href="/login">Начать</a></button>
    <script src="/js/slider.js"></script>
</body>

</html>