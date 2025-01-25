deleteAlbumButton.addEventListener('click', () => {
    console.log('Кнопка "Удалить альбом" нажата'); // Проверка
    if (selectedAlbumId) {
        fetch(`/album/${selectedAlbumId}/move-to-trash`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Удаляем альбом из интерфейса
                const albumElement = document.querySelector(`.album[data-album-id="${selectedAlbumId}"]`);
                if (albumElement) {
                    albumElement.remove();
                }
                alert('Альбом перемещён в корзину');
            } else {
                alert('Ошибка при перемещении альбома в корзину');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Ошибка при перемещении альбома в корзину');
        });
    }
});