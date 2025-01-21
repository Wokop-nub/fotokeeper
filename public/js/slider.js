// Получаем все слайды
const slides = document.querySelectorAll('.slide');
let currentIndex = 0;

// Функция для показа текущего слайда
function showSlide(index) {
    // Скрываем все слайды
    slides.forEach(slide => slide.classList.remove('active'));
    
    // Показываем нужный слайд
    slides[index].classList.add('active');
}

// Функция для переключения на следующий слайд
function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

// Запускаем показ первого слайда
showSlide(currentIndex);

// Интервал для автоматического переключения слайдов
setInterval(nextSlide, 5000); // Смена каждые 5 секунд
