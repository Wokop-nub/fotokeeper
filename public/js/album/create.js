document
    .getElementById("create-album-form")
    .addEventListener("submit", async function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение формы

        // Собираем данные формы
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Отправляем запрос на сервер
        const response = await fetch("/api/album/create", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.status == true) {
            // Успешная отправка
            window.location.href = "/";
        } else {
            // Обрабатываем ошибки валидации
            alert(result.massage);
        }
    });
