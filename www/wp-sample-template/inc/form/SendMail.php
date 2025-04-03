<?php

/**
 * Обработка формы отправки письма.
 * Если форма отправлена, отправляет письмо с использованием SMTP.
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form__email'])) {

    require_once "SendMailSmtpClass.php";

    // Константы для настроек
    define('SMTP_HOST', 'ssl://smtp.yandex.ru');
    define('SMTP_PORT', 465);
    define('SMTP_USER', 'Почта от кого письмо');
    define('SMTP_PASS', 'Пароль почты');
    define('SMTP_FROM', 'От кого письмо текст');
    define('SMTP_TO', 'Почта куда отправлять');

    // Проверка данных формы
    $requiredFields = ['form__name', 'form__email', 'form__tel', 'form__textarea', 'form__tovar', 'form__kolvo'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            die("Ошибка: Поле '$field' не заполнено.");
        }
    }

    // Создание объекта для отправки письма
    $mailSMTP = new SendMailSmtpClass(SMTP_USER, SMTP_PASS, SMTP_HOST, SMTP_FROM, SMTP_PORT);

    // Формирование темы письма
    $subject = "Заказ с " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'неизвестного источника');

    // Формирование сообщения
    $message = "Контактные данные: " . htmlspecialchars($_POST['form__name']) . "\n" .
               "Эл. почта: " . htmlspecialchars($_POST['form__email']) . "\n" .
               "Телефон: " . htmlspecialchars($_POST['form__tel']) . "\n" .
               "Комментарии к заказу: " . htmlspecialchars($_POST['form__textarea']) . "\n" .
               "Товар: " . htmlspecialchars($_POST['form__tovar']) . "\n" .
               "Кол-во: " . htmlspecialchars($_POST['form__kolvo']);

    // Заголовки письма
    $headers = "From: " . SMTP_USER . "\r\n" .
               "Reply-To: " . SMTP_USER . "\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n";

    // Отправка письма
    try {
        $result = $mailSMTP->send(SMTP_TO, $subject, $message, $headers);
        if ($result === true) {
            echo "Письмо успешно отправлено!";
        } else {
            echo "Ошибка при отправке письма: " . $result;
        }
    } catch (Exception $e) {
        echo "Ошибка при отправке письма: " . $e->getMessage();
    }
} else {
    echo "Ошибка: Неверный метод запроса или отсутствуют данные формы.";
}

?>
