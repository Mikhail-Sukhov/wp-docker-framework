<?php
/**
 * Главная страница.
 *
 * Этот файл отвечает за отображение содержимого главной страницы.
 * Он подключает шапку, основной контент, постраничную навигацию и подвал сайта.
 *
 */

get_header(); // Подключаем шапку сайта
?>

<main class="main row" role="main">

	<?php get_template_part( 'content', get_theme_mod( 'home_page_temp', '' ) ); // Подключаем 'content.php' ?>

</main>

<?php
/**
 * Выводим постраничную навигацию.
 */
the_posts_pagination(
	array(
		'end_size'  => 2, // количество страниц на концах
		'mid_size'  => 2, // количество страниц вокруг текущей
		'prev_text' => '&larr;',
		'next_text' => '&rarr;',
	)
);
?>

<?php get_footer(); // Подключаем подвал сайта ?>