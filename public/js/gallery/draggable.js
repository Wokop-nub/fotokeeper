class Draggable {
    constructor(element) {
        this.element = element;
        this.element.draggable = true;
        this.lastHoveredTarget = null;

        // Обработчики событий перетаскивания
        this.element.addEventListener(
            "dragstart",
            this.handleDragStart.bind(this)
        );
        this.element.addEventListener("dragend", this.handleDragEnd.bind(this));

        // Привязываем контекст к методу trackHoveredElement
        this.trackHoveredElement = this.trackHoveredElement.bind(this);
    }

    handleDragStart() {
        this.element.style.opacity = "0.8";
        // Сохраняем текущий элемент, над которым находится курсор
        document.addEventListener("dragover", this.trackHoveredElement, false);
    }

    handleDragEnd() {
        this.element.style.opacity = "1";
        document.removeEventListener("dragover", this.trackHoveredElement);

        // Проверяем, был ли элемент отпущен над альбомом
        if (this.lastHoveredTarget?.closest(".album-header")) {
            const targetAlbumId =
                this.lastHoveredTarget.closest(".album-header").dataset.albumId;
            this.request(targetAlbumId);
        }

        this.lastHoveredTarget = null;
    }

    trackHoveredElement(event) {
        event.preventDefault();
        this.lastHoveredTarget = event.target;
    }

    sendRequest(url, data) {
        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: data,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
    }

    request(targetAlbumId) {
        throw new Error("Method request() must be implemented");
    }
}

class File extends Draggable {
    constructor(element) {
        super(element);
        this.id = element.dataset.photoId;
    }

    request(targetAlbumId) {
        const url = "/api/photo/moving";
        const data = JSON.stringify({
            albumId: targetAlbumId,
            id: this.id,
        });

        this.sendRequest(url, data);
    }

    handleDragEnd() {
        this.element.style.opacity = "1";
        document.removeEventListener("dragover", this.trackHoveredElement);

        // Проверяем, был ли элемент отпущен над альбомом
        if (this.lastHoveredTarget?.closest(".album-header")) {
            const targetAlbumId =
                this.lastHoveredTarget.closest(".album-header").dataset.albumId;
            this.request(targetAlbumId);
        } else if (this.lastHoveredTarget?.closest(".grid-container")) {
            this.request(null);
        }

        this.lastHoveredTarget = null;
    }
}

class Album extends Draggable {
    constructor(element) {
        super(element);
        this.id = element.dataset.albumId;
    }

    request(targetAlbumId) {
        const url = "/api/album/moving";
        const data = JSON.stringify({
            albumId: targetAlbumId,
            id: this.id,
        });

        this.sendRequest(url, data);
    }
}

class Photo extends Draggable {
    constructor(element) {
        super(element);
        this.id = element.querySelector("img").dataset.photoId;
    }

    request(targetAlbumId) {
        const url = "/api/photo/moving";
        const data = JSON.stringify({
            albumId: targetAlbumId,
            id: this.id,
        });

        this.sendRequest(url, data);
    }

    handleDragStart() {
        super.handleDragStart();
        this.element.style.opacity = "0.4";
    }
}

document.querySelectorAll(".album-photos img").forEach((img) => {
    new File(img);
});
document.querySelectorAll(".album-header").forEach((el) => {
    new Album(el);
});
document.querySelectorAll(".photo").forEach((el) => {
    new Photo(el);
});
