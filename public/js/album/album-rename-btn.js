async function renameAlbum(form, id) {
    // Отправляем запрос на сервер
    const response = await fetch("/api/album/rename", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            id: id,
            name: form.querySelector('input[name="name"]').value,
        }),
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

export { renameAlbum };
