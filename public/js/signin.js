document
    .getElementById("signin")
    .addEventListener("submit", async function (event) {
        event.preventDefault(); // Предотвращаем стандартное поведение формы

        // Собираем данные формы
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Отправляем запрос на сервер
        const response = await fetch("/api/signin", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.status == true) {
            // Успешная отправка
            window.location.href = "/index";
        } else {
            // Обрабатываем ошибки валидации
            alert(result.message);
        }
    });
