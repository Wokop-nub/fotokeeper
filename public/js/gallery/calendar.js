const selectToggle = document.querySelector(".select-toggle");
const selectDropdown = document.querySelector(".select-dropdown");
const selectedImage = document.querySelector("#selected-image");
const selectOptions = document.querySelectorAll(".select-option");

// Показываем/скрываем выпадающий список при нажатии на картинку
selectToggle.addEventListener("click", () => {
    selectDropdown.style.display =
        selectDropdown.style.display === "block" ? "none" : "block";
});

// Закрываем выпадающий список при клике вне
document.addEventListener("click", (e) => {
    if (
        !selectToggle.contains(e.target) &&
        !selectDropdown.contains(e.target)
    ) {
        selectDropdown.style.display = "none";
    }
});
