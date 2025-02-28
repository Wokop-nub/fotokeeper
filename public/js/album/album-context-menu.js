import { renameAlbum } from "./album-rename.js";
import { deleteAlbum } from "./album-delete.js";
import { uploadFile } from "./album-upload.js";
const contextMenu = document.getElementById("context-menu");
const renameForm = document.querySelector("#rename-album");
const deleteForm = document.querySelector("#delete-album");
const uploadForm = document.querySelector("#upload-album");

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

// Скрываем контекстное меню при клике на кнопку
contextMenu.querySelectorAll("button").forEach((btn) => {
    btn.addEventListener("click", () => {
        contextMenu.style.display = "none";
    });
});

renameForm.addEventListener("submit", (event) => {
    event.preventDefault();
    renameAlbum(renameForm, selectedAlbumId);
});
deleteForm.addEventListener("submit", (event) => {
    event.preventDefault();
    deleteAlbum(selectedAlbumId);
});
uploadForm.addEventListener("submit", (event) => {
    event.preventDefault();
    uploadFile(uploadForm, selectedAlbumId);
});
