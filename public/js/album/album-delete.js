async function deleteAlbum(id) {
    // Отправляем запрос на сервер
    const response = await fetch("/api/album/move-to-trash", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            id: id,
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

export { deleteAlbum };
