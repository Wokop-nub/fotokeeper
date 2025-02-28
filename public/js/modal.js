// Функция для привязки обработчиков событий к модалкам
function bindModalEvents() {
    const openModalBtns = document.querySelectorAll(".openModalBtn");
    const modals = document.querySelectorAll(".modalka");

    // Открытие модального окна
    openModalBtns.forEach((btn) => {
        btn.removeEventListener("click", openModalHandler); // Удаляем старые обработчики
        btn.addEventListener("click", openModalHandler); // Добавляем новые обработчики
    });

    // Закрытие модального окна по нажатию вне его области
    modals.forEach((modal) => {
        modal.removeEventListener("mousedown", closeModalHandler); // Удаляем старые обработчики
        modal.addEventListener("mousedown", closeModalHandler); // Добавляем новые обработчики
    });
}

// Обработчик для открытия модалки
function openModalHandler() {
    const modals = document.getElementsByClassName("modalka");
    for (let i = 0; i < modals.length; i++) {
        modals[i].style.display = "none";
    }

    const modalId = this.getAttribute("data-modal");
    const modal = document.getElementById(modalId);
    modal.style.display = "flex";
    document.body.classList.add("modalka-open");

    if (modalId == "navLK") {
        setTimeout(() => {
            modal.getElementsByClassName("navLK__bar")[0].style.transform =
                "translateX(0px)";
        }, 10);
    }
}

// Обработчик для закрытия модалки
function closeModalHandler(event) {
    if (event.target === this) {
        if (this.id == "navLK") {
            this.getElementsByClassName("navLK__bar")[0].style.transform =
                "translateX(200vw)";
            setTimeout(() => {
                this.style.display = "none";
                document.body.classList.remove("modalka-open");
            }, 200);
        } else {
            this.style.display = "none";
            document.body.classList.remove("modalka-open");
        }
    }
}

bindModalEvents();
export { bindModalEvents };
