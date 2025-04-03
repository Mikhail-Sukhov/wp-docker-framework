<?php
/**
 * Шаблон архива.
 *
 * Этот файл отвечает за отображение содержимого архива.
 * Он подключает шапку, основной контент, навигацию по архивам и подвал сайта.
 *
 */

get_header(); // Подключаем шапку сайта
?>

<section class="m-archive">
	<h1 class="m-archive__title"><?php echo single_cat_title( '', false ); ?></h1>
	<?php the_archive_description( '<div class="m-archive__description">', '</div>' ); ?>
</section>

<main class="main row" role="main">

	<?php get_template_part( 'content', get_theme_mod( 'archive_page_tem', '' ) ); // Подключаем 'content.php' ?>

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