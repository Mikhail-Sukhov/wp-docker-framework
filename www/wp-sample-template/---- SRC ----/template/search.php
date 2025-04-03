<?php
/**
 * Шаблон страницы результатов поиска.
 *
 * Этот файл отвечает за отображение результатов поиска на сайте.
 * Он подключает шапку, форму поиска, результаты поиска, навигацию по архивам и подвал сайта.
 *
 */

get_header(); // Подключаем шапку сайта
?>

<section class="m-search">

	<h2 class="m-search__title"><?php echo esc_html__( 'You were looking for:', '<%= theme %>' ); ?> "<?php the_search_query(); ?>"</h2>

	<div class="m-search__box">

		<?php get_search_form(); // Подключаем форму поиска ?>

		<?php if ( have_posts() ) : ?>

			<h2 class="m-search__result"><?php echo esc_html__( 'Search Results:', '<%= theme %>' ); ?></h2>

		</div>

	</section>

	<main class="main row" role="main">

		<?php get_template_part( 'content', get_theme_mod( 'search_page_temp', '' ) ); // Подключаем 'content.php' ?>

	</main>

		<?php else : ?>
			<div class="m-search__mess">
				<p class="m-search__err"><?php echo esc_html__( 'The search did not produce any results', '<%= theme %>' ); ?></p>
			</div>
		</div>
	</section>
		<?php endif; ?>

<?php get_template_part( 'archive-navigation' ); // Подключаем навигацию по архивам ?>

<?php get_footer(); // Подключаем подвал сайта ?>