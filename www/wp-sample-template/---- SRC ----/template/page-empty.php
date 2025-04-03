<?php
/**
 * Template Name: Пустая страница
 * 
 * Шаблон пустой страницы.
 *
 * Этот файл отвечает за отображение пустой страницы.
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
	 * Если посты есть, выводим их содержимое.
	 */
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>

			<article class="post post--empty" id="post__<?php the_ID(); ?>">

				<h2 class="post--empty__title"><?php the_title(); ?></h2>

				<div class="post--empty__content"><?php the_content(); ?></div>

			</article>

		<?php
		endwhile;
	else :
		/**
		 * Если постов нет, ничего не отображаем.
		 */
	endif;
	?>

</main>

<?php get_footer(); // Подключаем подвал сайта ?>