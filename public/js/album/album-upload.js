async function uploadFile(form, id) {
    const formData = new FormData();

    // Добавляем ID альбома
    formData.append("id", id);

    // Добавляем все выбранные файлы из input[type="file"]
    const fileInput = form.querySelector('input[name="file[]"]');
    if (fileInput && fileInput.files.length > 0) {
        for (let i = 0; i < fileInput.files.length; i++) {
            formData.append("file[]", fileInput.files[i]); // Каждый файл добавляется как отдельное поле
        }
    }

    // Отправляем запрос на сервер
    const response = await fetch("/api/album/upload", {
        method: "POST",
        body: formData,
    });

    const result = await response.json();

    if (result.status == true) {
        // Успешная отправка
        location.reload();
    } else {
        // Обрабатываем ошибки валидации
        console.log(result);
        alert(result);
    }
}

export { uploadFile };

// Создаем объект DataTransfer для хранения файлов
const dt = new DataTransfer();

// Добавляем обработчик события 'change' для input[type="file"]
document.querySelectorAll(".input-file input[type=file]").forEach((input) => {
    input.addEventListener("change", function () {
        // Находим элемент для отображения списка файлов
        const filesList = this.closest(".input-file").nextElementSibling;
        filesList.innerHTML = ""; // Очищаем список

        // Перебираем выбранные файлы и добавляем их в интерфейс
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files.item(i);

            // Создаем HTML-элемент для отображения имени файла и кнопки удаления
            const listItem = document.createElement("div");
            listItem.className = "input-file-list-item";

            const fileName = document.createElement("span");
            fileName.className = "input-file-list-name";
            fileName.textContent = file.name;

            const removeButton = document.createElement("a");
            removeButton.href = "#";
            removeButton.className = "input-file-list-remove";
            removeButton.textContent = "x";
            removeButton.onclick = function (e) {
                e.preventDefault();
                removeFilesItem(this);
            };

            listItem.appendChild(fileName);
            listItem.appendChild(removeButton);
            filesList.appendChild(listItem);

            // Добавляем файл в DataTransfer
            dt.items.add(file);
        }

        // Обновляем файлы в input[type="file"]
        this.files = dt.files;
    });
});

// Функция для удаления файла из списка
function removeFilesItem(target) {
    // Получаем имя файла
    const name = target.previousElementSibling.textContent;

    // Находим соответствующий input[type="file"]
    const input = target
        .closest(".input-file-row")
        .querySelector('input[type="file"]');

    // Удаляем элемент из DOM
    target.closest(".input-file-list-item").remove();

    // Ищем и удаляем файл из DataTransfer
    for (let i = 0; i < dt.items.length; i++) {
        if (name === dt.items[i].getAsFile().name) {
            dt.items.remove(i);
            break; // Прерываем цикл после удаления
        }
    }

    // Обновляем файлы в input[type="file"]
    input.files = dt.files;
}
