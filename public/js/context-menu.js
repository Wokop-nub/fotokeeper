document.addEventListener('DOMContentLoaded', function() {
    const contextMenu = document.getElementById('context-menu');
    const renameButton = document.getElementById('rename-button');
    const deleteButton = document.getElementById('delete-button');
    const renameFormContainer = document.getElementById('rename-form-container');
    const renameForm = document.getElementById('rename-form');
    const cancelRenameButton = document.getElementById('cancel-rename');
    let selectedPhoto = null;

    // Показываем контекстное меню при клике правой кнопкой мыши
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();

        
        if (event.target.tagName === 'IMG') {
            selectedPhoto = event.target;
            console.log('z nen');
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }
    });

    // Скрываем контекстное меню при клике вне его
    document.addEventListener('click', function() {
        contextMenu.style.display = 'none';
    });

    // Обработка нажатия на кнопку "Переименовать"
    renameButton.addEventListener('click', function() {
        contextMenu.style.display = 'none'; // Скрываем контекстное меню
        renameFormContainer.style.display = 'block'; // Показываем форму переименования
        renameFormContainer.style.left = `${contextMenu.style.left}`;
        renameFormContainer.style.top = `${contextMenu.style.top}`;

        // Устанавливаем текущее имя фотографии в поле ввода
        const currentFilename = selectedPhoto.dataset.filename;
        document.getElementById('new-filename').value = currentFilename.replace(/\.[^/.]+$/, ""); // Убираем расширение файла
    });

    // Обработка отмены переименования
    cancelRenameButton.addEventListener('click', function() {
        renameFormContainer.style.display = 'none'; // Скрываем форму переименования
    });

    // Обработка отправки формы переименования
    renameForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const photoId = selectedPhoto.dataset.photoId;
        const newFilename = document.getElementById('new-filename').value;

        fetch(`/photos/${photoId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ filename: newFilename })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновляем имя фотографии на странице
                selectedPhoto.dataset.newfilename = data.newFilename;
                selectedPhoto.title = newFilename;
                renameFormContainer.style.display = 'none'; // Скрываем форму переименования
                alert('Фотография успешно переименована!');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Обработка удаления фотографии (если нужно)
    deleteButton.addEventListener('click', function() {
        if (selectedPhoto) {
            const photoId = selectedPhoto.dataset.photoId;
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