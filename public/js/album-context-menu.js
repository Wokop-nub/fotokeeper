const contextMenu = document.getElementById("context-menu");
const addPhotoButton = document.getElementById("add-photo-button");
const renameAlbumButton = document.getElementById("rename-album-button");
const deleteAlbumButton = document.getElementById("delete-album-button");
const addPhotoMenu = document.getElementById("add-photo-menu");
const uploadFromDeviceButton = document.getElementById("upload-from-device");
const uploadFromAlbumButton = document.getElementById("upload-from-album");
const uploadFromPhotosButton = document.getElementById("upload-from-photos");
const cancelAddPhotoButton = document.getElementById("cancel-add-photo");

let selectedAlbumId = null;

// Показываем контекстное меню при клике правой кнопкой мыши
document.addEventListener("contextmenu", (event) => {
    event.preventDefault();
    if (event.target.closest(".album")) {
        selectedAlbumId = event.target.closest(".album").dataset.albumId;
        contextMenu.style.display = "block";
        contextMenu.style.left = `${event.pageX}px`;
        contextMenu.style.top = `${event.pageY}px`;
    }
});

// Скрываем контекстное меню при клике вне его
document.addEventListener("click", (event) => {
    if (!contextMenu.contains(event.target)) {
        contextMenu.style.display = "none";
    }
});

// Обработка кнопки "Добавить фото"
addPhotoButton.addEventListener("click", (event) => {
    event.stopPropagation();
    addPhotoMenu.style.display = "block";
    addPhotoMenu.style.left = `${event.pageX}px`;
    addPhotoMenu.style.top = `${event.pageY}px`;
});

// Обработка кнопки "Отмена" во вложенном меню
cancelAddPhotoButton.addEventListener("click", () => {
    addPhotoMenu.style.display = "none";
});

// Обработка кнопки "Загрузить с устройства"
uploadFromDeviceButton.addEventListener("click", () => {
    console.log("Загрузить с устройства");
    addPhotoMenu.style.display = "none";
});

// Обработка кнопки "Загрузить с альбома"
uploadFromAlbumButton.addEventListener("click", () => {
    console.log("Загрузить с альбома");
    addPhotoMenu.style.display = "none";
});

// Обработка кнопки "Загрузить из фото"
uploadFromPhotosButton.addEventListener("click", () => {
    console.log("Загрузить из фото");
    addPhotoMenu.style.display = "none";
});

// Обработка кнопки "Переименовать альбом"
renameAlbumButton.addEventListener("click", () => {
    if (selectedAlbumId) {
        const newName = prompt("Введите новое название альбома:");
        if (newName) {
            fetch(`/album/${selectedAlbumId}/rename`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ name: newName }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const albumTitleElement = document.querySelector(
                            `.album[data-album-id="${selectedAlbumId}"] .album-title`
                        );
                        if (albumTitleElement) {
                            albumTitleElement.textContent = newName;
                        }
                        alert("Название альбома успешно изменено");
                    } else {
                        alert("Ошибка при изменении названия альбома");
                    }
                })
                .catch((error) => {
                    console.error("Ошибка:", error);
                    alert("Ошибка при изменении названия альбома");
                });
        }
    }
});

// Обработка кнопки "Удалить альбом"
deleteAlbumButton.addEventListener("click", () => {
    if (selectedAlbumId) {
        fetch(`/album/${selectedAlbumId}/move-to-trash`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const albumElement = document.querySelector(
                        `.album[data-album-id="${selectedAlbumId}"]`
                    );
                    if (albumElement) {
                        albumElement.remove();
                    }
                    alert("Альбом перемещён в корзину");
                } else {
                    alert("Ошибка при перемещении альбома в корзину");
                }
            })
            .catch((error) => {
                console.error("Ошибка:", error);
                alert("Ошибка при перемещении альбома в корзину");
            });
    }
});
