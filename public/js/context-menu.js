document.addEventListener('DOMContentLoaded', () => {
    const contextMenu = document.getElementById('context-menu');
    let selectedPhotoId = null;

    // Обработчик для правого клика на фотографию
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('contextmenu', (event) => {
            event.preventDefault(); // Отключаем стандартное меню

            // Сохраняем ID фотографии для удаления
            selectedPhotoId = item.getAttribute('data-id');

            // Показываем кастомное меню
            const rect = item.getBoundingClientRect();
            contextMenu.style.left = `${event.clientX}px`;
            contextMenu.style.top = `${event.clientY}px`;
            contextMenu.classList.remove('hidden');
        });
    });

    // Обработчик для клика на кнопку "Удалить" в контекстном меню
    document.querySelector('.delete-photo').addEventListener('click', () => {
        if (selectedPhotoId) {
            fetch(`/photos/${selectedPhotoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    // Удаляем элемент из DOM
                    const photoToRemove = document.querySelector(`.gallery-item[data-id="${selectedPhotoId}"]`);
                    if (photoToRemove) {
                        photoToRemove.remove();
                    }
                } else {
                    console.error('Ошибка при удалении фотографии');
                }
            })
            .catch(error => console.error('Ошибка:', error));
        }

        // Скрыть контекстное меню
        contextMenu.classList.add('hidden');
    });

    // Закрытие контекстного меню при клике вне
    document.addEventListener('click', (event) => {
        if (!contextMenu.contains(event.target)) {
            contextMenu.classList.add('hidden');
        }
    });
});
