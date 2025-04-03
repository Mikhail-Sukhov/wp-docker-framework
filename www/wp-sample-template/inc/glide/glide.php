<?php

/**
 * Функция для получения списка имен изображений из указанной папки.
 *
 * @param string $patch Путь к папке с изображениями относительно темы.
 * @return array Массив имен изображений.
 */
function get_image_names($patch) {
    // Получаем абсолютный путь к папке с изображениями в текущей теме
    $folderPath = get_template_directory() . $patch;

    // Массив с расширениями изображений
    $extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    // Инициализируем массив для хранения названий изображений
    $imageNames = [];

    // Перебираем все расширения и ищем файлы
    foreach ($extensions as $ext) {
        $imageFiles = glob($folderPath . '/*.' . $ext);
        foreach ($imageFiles as $imageFile) {
            // Получаем только имя файла (без пути)
            $imageName = basename($imageFile);
            // Добавляем имя файла в массив
            $imageNames[] = $imageName;
        }
    }

    return $imageNames;
}

/**
 * Функция для вывода слайдера с использованием библиотеки Glide.
 *
 * @param string $patch Путь к папке с изображениями относительно темы.
 * @param bool $wrap Определяет, нужно ли обернуть слайдер в дополнительный контейнер.
 * @param string $add_class Дополнительные классы для контейнера слайдера.
 */
if ( ! function_exists( 'get_glide' ) ) {
	function get_glide( $patch, $wrap = false, $add_class = "" ) {
		// Определяем класс для обертки слайдера
		$wrap_class = $wrap ? " glide--wrap " : ( $add_class ? " " : "" );

		// Начало вывода HTML-кода слайдера
		echo '<div class="glide' . esc_attr( $wrap_class . $add_class ) . '">';
			echo '<div class="glide__track" data-glide-el="track">';
				echo '<ul class="glide__slides">';
					// Получаем список имен изображений
					$imageNames = get_image_names( $patch );
					// Проходим по списку имен изображений и выводим каждое изображение
					foreach ( $imageNames as $imageName ) {
						echo '<li class="glide__slide">';
							echo '<a class="image-href" href="' . esc_url( get_template_directory_uri() . $patch . '/' . $imageName ) . '" >';
								echo '<img class="glide__images" src="' . esc_url( get_template_directory_uri() . $patch . '/pre/' . $imageName ) . '" >';
							echo '</a>';
						echo '</li>';
					}
				echo '</ul>';
			echo '</div>';

			// Вывод кнопок управления слайдером
			echo '<div class="glide__arrows" data-glide-el="controls">';
				echo '<button class="glide__arrow glide__arrow--left icon-left-2" data-glide-dir="<"></button>';
				echo '<button class="glide__arrow glide__arrow--right icon-right-2" data-glide-dir=">"></button>';
			echo '</div>';

		echo '</div>';
	}
}

?>
