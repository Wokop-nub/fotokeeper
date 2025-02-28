<!-- Контекстное меню -->
<div id="context-menu" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px;">
    <button class="openModalBtn" data-modal="upload-album-modal">Добавить фотографию</button>
    <button class="openModalBtn" data-modal="rename-album-modal">Переименовать альбом</button>
    <button class="openModalBtn" data-modal="delete-album-modal">Удалить альбом</button>
</div>

<div class="modalka" id="upload-album-modal">
    <form action="/api/album/rename" method="POST" id="upload-album">
        <div class="input-file-row">
            <label class="input-file">
                <input type="file" name="file[]" multiple>
                <span>Выберите файл</span>
            </label>
            <div class="input-file-list"></div>
        </div>
        <button type="submit">Загрузить</button>
    </form>
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
