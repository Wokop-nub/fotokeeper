<header class="header">
    <img src="/img/logo.svg" alt="logo">
    <nav class="nav">
        <a href="/upload" class="nav-link {{(!isset($active) or $active==1)?'active':'passive'}}">
            <img src="/img/photo-icon-{{(!isset($active) or $active==1)?'active':'passive'}}.svg" alt="photo">
            Фотографии
        </a>
        <a href="/album" class="nav-link {{(isset($active) and $active==2)?'active':'passive'}}">
            <img src="/img/album-icon-{{(isset($active) and $active==2)?'active':'passive'}}.svg" alt="album">
            Альбомы
        </a>
        <a href="/logout" class="nav-link active">
            <img src="/img/logout.svg" alt="album">
            Выход
        </a>
    </nav>
</header>
