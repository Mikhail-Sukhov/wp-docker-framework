
<?php
/**
 * Шаблон страницы.
 *
 * Этот файл отвечает за отображение содержимого страницы.
 * Он подключает шапку, основной контент, навигацию по записям,
 * комментарии и подвал сайта.
 *
 */

get_header(); // Подключаем шапку сайта
?>

<main class="main" role="main">

	<?php
	/**
	 * Проверяем, есть ли посты для отображения.
	 * Если посты есть, подключаем файл 'content.php' для отображения содержимого.
	 */
	if ( have_posts() ) :
		get_template_part( 'content' ); // Подключаем 'content.php'
	else :
		/**
		 * Если постов нет, ничего не отображаем.
		 */
	endif;
	?>

</main>

<?php

the_post_navigation(); // Выводим навигацию по записям

comments_template(); // Подключаем шаблон комментариев

get_footer(); // Подключаем подвал сайта