
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("upload-form");

    let btnForm = form.querySelector('.upload-button');
    let inputForm = form.querySelector('#photo-upload');




    btnForm.addEventListener("click", () => {
        inputForm.click();
        console.log(inputForm);
    })

    inputForm.addEventListener('change', function () {
        if (this.value) {
            // По загрузке файла делаешь отправук формы
            console.log("Оппа, выбрали файл!");
            console.log(this.value);
            btnForm.setAttribute('type', 'sumbit');
        } else { // Если после выбранного тыкнули еще раз, но дальше cancel
            console.log("Файл не выбран");
        }
    });
})
