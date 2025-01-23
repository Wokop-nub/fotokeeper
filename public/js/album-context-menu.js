document.addEventListener('DOMContentLoaded', () => {
    const contextMenu = document.getElementById('context-menu');
    const addPhotoButton = document.getElementById('add-photo-button');
    const renameAlbumButton = document.getElementById('rename-album-button');
    const deleteAlbumButton = document.getElementById('delete-album-button');
    let selectedAlbumId = null;

    // Показываем контекстное меню при клике правой кнопкой мыши
    document.addEventListener('contextmenu', (event) => {
        event.preventDefault();

        // Проверяем, что клик был по альбому
        if (event.target.closest('.album')) {
            selectedAlbumId = event.target.closest('.album').dataset.albumId; // Получаем ID альбома
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }
    });

    // Скрываем контекстное меню при клике вне его
    document.addEventListener('click', () => {
        contextMenu.style.display = 'none';
    });

    // Обработка кнопки "Добавить фотографию"
    addPhotoButton.addEventListener('click', () => {
        if (selectedAlbumId) {
            // Логика для добавления фотографии
            alert(`Добавить фотографию в альбом с ID: ${selectedAlbumId}`);
        }
    });

    // Обработка кнопки "Переименовать альбом"
    renameAlbumButton.addEventListener('click', () => {
        if (selectedAlbumId) {
            const newName = prompt('Введите новое название альбома:');
            if (newName) {
                // Логика для переименования альбома
                fetch(`/album/${selectedAlbumId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ name: newName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Перезагружаем страницу
                    }
                });
            }
        }
    });

    // Обработка кнопки "Удалить альбом"
    deleteAlbumButton.addEventListener('click', () => {
        if (selectedAlbumId) {
            // Логика для удаления альбома (перемещения в корзину)
            fetch(`/album/${selectedAlbumId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload(); // Перезагружаем страницу
                }
            });
        }
    });
});