document.addEventListener('DOMContentLoaded', () => {
    const contextMenu = document.getElementById('context-menu');
    const addPhotoButton = document.getElementById('add-photo-button');
    const renameAlbumButton = document.getElementById('rename-album-button');
    const deleteAlbumButton = document.getElementById('delete-album-button');

    // Проверяем, что все элементы найдены
    if (!contextMenu || !addPhotoButton || !renameAlbumButton || !deleteAlbumButton) {
        console.error('Один или несколько элементов контекстного меню не найдены в DOM');
        return;
    }

    let selectedAlbumId = null;

    // Показываем контекстное меню при клике правой кнопкой мыши
    document.addEventListener('contextmenu', (event) => {
        event.preventDefault();
        console.log('Правый клик зарегистрирован'); // Проверка
    
        if (event.target.closest('.album')) {
            selectedAlbumId = event.target.closest('.album').dataset.albumId;
            console.log('Выбран альбом с ID:', selectedAlbumId); // Проверка
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }
    });

    document.addEventListener('click', (event) => {
        if (!contextMenu.contains(event.target)) {
            contextMenu.style.display = 'none';
        }
    });

    // Обработка кнопки "Добавить фотографию"
    addPhotoButton.addEventListener('click', () => {
        console.log('Кнопка "Добавить фотографию" нажата'); // Проверка
        if (selectedAlbumId) {
            alert(`Добавить фотографию в альбом с ID: ${selectedAlbumId}`);
        }
    });
    
    renameAlbumButton.addEventListener('click', () => {
        console.log('Кнопка "Переименовать альбом" нажата'); // Проверка
        if (selectedAlbumId) {
            const newName = prompt('Введите новое название альбома:');
            if (newName) {
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
                        window.location.reload();
                    }
                });
            }
        }
    });
    
    deleteAlbumButton.addEventListener('click', () => {
        console.log('Кнопка "Удалить альбом" нажата'); // Проверка
        if (selectedAlbumId) {
            fetch(`/album/${selectedAlbumId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    });
});