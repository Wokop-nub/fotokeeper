const contextMenu = document.getElementById("context-menu");
const deleteForm = document.getElementById("delete-photo");
let selectedPhoto = null;

// Показываем контекстное меню при клике правой кнопкой мыши
document.addEventListener("contextmenu", function (event) {
    event.preventDefault();

    if (event.target.closest(".photo")) {
        selectedPhoto = event.target.dataset.photoId;
        contextMenu.style.display = "flex";
        contextMenu.style.left = `${event.pageX}px`;
        contextMenu.style.top = `${event.pageY}px`;
    }
});

// Скрываем контекстное меню при клике вне его
document.addEventListener("click", function () {
    contextMenu.style.display = "none";
});

// Обработка удаления фотографии (если нужно)
deleteForm.addEventListener("submit", function (event) {
    event.preventDefault();
    fetch("api/photo/delete", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            id: selectedPhoto,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch((error) => console.error("Error:", error));
});
