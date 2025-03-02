document.querySelectorAll(".album-header").forEach(function (header) {
    header.addEventListener("click", function () {
        const children = this.nextElementSibling;
        const icon = this.querySelector(".toggle-icon");
        // Меняем стрелочку при каждом клике
        icon.textContent === "▶"
            ? (icon.textContent = "▼")
            : (icon.textContent = "▶");

        if (children) {
            children.classList.toggle("hidden");
        }
    });
});
