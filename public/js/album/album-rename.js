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
        location.reload();
    } else {
        alert(result.message);
    }
}

export { renameAlbum };
