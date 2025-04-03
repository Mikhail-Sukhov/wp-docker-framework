/**
 * Скрипт для обработки формы заказа.
 *
 * Этот скрипт обрабатывает отправку формы, изменение количества товара,
 * выбор продукта и расчет итоговой суммы.
 *
 */

document.addEventListener("DOMContentLoaded", function() {
    /**
     * Обработка отправки формы.
     *
     * @param {Event} evt - Событие отправки формы.
     */
    document.addEventListener("submit", function(evt) {
        if (evt.target.id === "form__form") {
            var http = new XMLHttpRequest(), f = evt.target;
            evt.preventDefault();
            http.open("POST", PATCHSENDMAIL, true);
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    f.querySelector(".js-form__btn-submit").innerHTML = "Ваш заказ принят";
                    f.querySelector(".js-form__btn-submit").classList.remove("form__btn-submit--def");
                    f.querySelector(".js-form__btn-submit").classList.add("form__btn-submit--valid");
                }
            }
            http.onerror = function() {
                f.querySelector(".js-form__btn-submit").innerHTML = "Ошибка отправки";
                f.querySelector(".js-form__btn-submit").classList.remove("form__btn-submit--def");
                f.querySelector(".js-form__btn-submit").classList.add("form__btn-submit--invalid");
            }
            http.send(new FormData(f));
        }
    }, false);

    /**
     * Обработка изменения количества и выбора продукта.
     *
     * @param {Event} evt - Событие изменения.
     */
    document.addEventListener("change", function(evt) {
        if (evt.target.id === "form__quantity" || evt.target.id === "form__product") {
            const form = evt.target.closest("#form__form");
            const sum = form.querySelector("#form__quantity");
            const select = form.querySelector("#form__product");

            /**
             * Расчет итоговой суммы.
             *
             * @param {number} match - Количество товара.
             */
            function getAllPriceValue(match) {
                let product;
                if (select.value.split(' -- ')[1]) {
                    product = select.value.split(' -- ')[1];
                } else {
                    product = 0;
                }
                form.querySelector("#form__price-all").value = product * match;
            }

            getAllPriceValue(sum.value);
        }
    });

    /**
     * Обработка кликов на кнопки увеличения/уменьшения количества.
     *
     * @param {Event} evt - Событие клика.
     */
    document.addEventListener("click", function(evt) {
        if (evt.target.classList.contains("form__step")) {
            const form = evt.target.closest("#form__form");
            const sum = form.querySelector("#form__quantity");
            const select = form.querySelector("#form__product");

            /**
             * Расчет итоговой суммы.
             *
             * @param {number} match - Количество товара.
             */
            function getAllPriceValue(match) {
                let product;
                if (select.value.split(' -- ')[1]) {
                    product = select.value.split(' -- ')[1];
                } else {
                    product = 0;
                }
                form.querySelector("#form__price-all").value = product * match;
            }

            getAllPriceValue(sum.value);
        }
    });

    /**
     * Обработка кнопок вне формы.
     *
     * @param {Event} evt - Событие клика.
     */
    document.addEventListener("click", function(evt) {
        if (evt.target.classList.contains("button__get")) {
            const slugGet = evt.target.dataset.get;
            const form = document.querySelector("#form__form"); // Предполагаем, что у вас есть только одна форма на странице
            const select = form.querySelector("#form__product");
            const options = select.getElementsByTagName('option');

            for (let i = 0; i < options.length; i++) {
                if (options[i].dataset.id === slugGet) {
                    select.value = options[i].value;
                    const sum = form.querySelector("#form__quantity");
                    getAllPriceValue(sum.value, form);
                    break;
                }
            }
        }
    });

    /**
     * Функция для расчета итоговой суммы.
     *
     * @param {number} match - Количество товара.
     * @param {HTMLElement} form - Форма заказа.
     */
    function getAllPriceValue(match, form) {
        const select = form.querySelector("#form__product");
        let product;
        if (select.value.split(' -- ')[1]) {
            product = select.value.split(' -- ')[1];
        } else {
            product = 0;
        }
        form.querySelector("#form__price-all").value = product * match;
    }
});