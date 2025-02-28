<!-- Контекстное меню -->
<div id="context-menu" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px;">
    {{-- <button id="add-photo-button">Добавить фотографию</button> --}}
    <button class="openModalBtn" data-modal="rename-album-modal">Переименовать альбом</button>
    <button class="openModalBtn" data-modal="delete-album-modal">Удалить альбом</button>
</div>

<div class="modalka" id="rename-album-modal">
    <form action="/api/album/rename" method="POST" id="rename-album">
        <input type="text" name="name" placeholder="Название альбома" required>
        <button type="submit">Переименовать</button>
    </form>
</div>

<div class="modalka" id="delete-album-modal">
    <form action="/api/album/rename" method="POST" id="delete-album">
        <button type="submit">Удалить</button>
    </form>
</div>
