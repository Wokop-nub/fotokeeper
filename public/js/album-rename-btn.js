renameAlbumButton.addEventListener('click', () => {
    console.log('Кнопка "Переименовать альбом" нажата'); // Проверка
    if (selectedAlbumId) {
        const newName = prompt('Введите новое название альбома:');
        if (newName) {
            fetch(`/album/${selectedAlbumId}/rename`, {
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
                    // Обновляем название альбома в интерфейсе
                    const albumTitleElement = document.querySelector(`.album[data-album-id="${selectedAlbumId}"] .album-title`);
                    if (albumTitleElement) {
                        albumTitleElement.textContent = newName;
                    }
                    alert('Название альбома успешно изменено');
                } else {
                    alert('Ошибка при изменении названия альбома');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Ошибка при изменении названия альбома');
            });
        }
    }
});