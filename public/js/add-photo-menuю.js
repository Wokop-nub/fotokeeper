const addPhotoMenu = document.getElementById('add-photo-menu');
const uploadFromDeviceButton = document.getElementById('upload-from-device');
const uploadFromAlbumButton = document.getElementById('upload-from-album');
const uploadFromPhotosButton = document.getElementById('upload-from-photos');
const cancelAddPhotoButton = document.getElementById('cancel-add-photo');

// Показываем вложенное меню при клике на "Добавить фото"
addPhotoButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Останавливаем всплытие, чтобы основное меню не скрывалось
    addPhotoMenu.style.display = 'block';
    addPhotoMenu.style.left = `${event.pageX}px`;
    addPhotoMenu.style.top = `${event.pageY}px`;
});

// Скрываем вложенное меню при клике на "Отмена"
cancelAddPhotoButton.addEventListener('click', () => {
    addPhotoMenu.style.display = 'none';
});

// Обработка кнопки "Загрузить с устройства"
uploadFromDeviceButton.addEventListener('click', () => {
    console.log('Загрузить с устройства');
    // Логика для загрузки с устройства
    addPhotoMenu.style.display = 'none';
});

// Обработка кнопки "Загрузить с альбома"
uploadFromAlbumButton.addEventListener('click', () => {
    console.log('Загрузить с альбома');
    // Логика для загрузки с альбома
    addPhotoMenu.style.display = 'none';
});

// Обработка кнопки "Загрузить из фото"
uploadFromPhotosButton.addEventListener('click', () => {
    console.log('Загрузить из фото');
    // Логика для загрузки из фото
    addPhotoMenu.style.display = 'none';
});

// Скрываем вложенное меню при клике вне его
document.addEventListener('click', (event) => {
    if (!addPhotoMenu.contains(event.target) && !addPhotoButton.contains(event.target)) {
        addPhotoMenu.style.display = 'none';
    }
});