document.addEventListener('DOMContentLoaded', function() {
    const contextMenu = document.getElementById('context-menu');
    const deleteButton = document.getElementById('delete-button');
    let selectedPhoto = null;

    // Показываем контекстное меню при клике правой кнопкой мыши
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        if (event.target.tagName === 'IMG') {
            selectedPhoto = event.target;
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }
    });

    // Скрываем контекстное меню при клике вне его
    document.addEventListener('click', function() {
        contextMenu.style.display = 'none';
    });

    // Обработка удаления фотографии
    deleteButton.addEventListener('click', function() {
        if (selectedPhoto) {
            const photoId = selectedPhoto.dataset.photoId; // Получаем ID фотографии из data-атрибута
            fetch(`/photos/${photoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selectedPhoto.remove(); // Удаляем фотографию из DOM
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});