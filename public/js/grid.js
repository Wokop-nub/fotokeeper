document.addEventListener("DOMContentLoaded", () => {
  const selectToggle = document.querySelector(".select-toggle-grid");
  const selectDropdown = document.querySelector(".select-dropdown-grid");
  const selectedImage = document.querySelector("#selected-image-grid");
  const selectOptions = document.querySelectorAll(".select-option-grid");

  // Показываем/скрываем выпадающий список при нажатии на картинку
  selectToggle.addEventListener("click", () => {
    selectDropdown.style.display =
      selectDropdown.style.display === "block" ? "none" : "block";
  });

  // Слушаем выбор пользователя
  selectOptions.forEach((option) => {
    option.addEventListener("click", () => {
      const imgSrc = option.querySelector("img").getAttribute("src");

      // Меняем текущую картинку на выбранную
      selectedImage.setAttribute("src", imgSrc);

      // Закрываем выпадающий список
      selectDropdown.style.display = "none";
    });
  });

  // Закрываем выпадающий список при клике вне
  document.addEventListener("click", (e) => {
    if (!selectToggle.contains(e.target) && !selectDropdown.contains(e.target)) {
      selectDropdown.style.display = "none";
    }
  });
});
