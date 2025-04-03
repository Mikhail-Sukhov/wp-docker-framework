<?php
/**
 * Шаблон шапки сайта.
 *
 * Этот файл отвечает за отображение шапки сайта.
 * Он подключает шапку HTML, контент шапки и различные виджеты.
 *
 */

get_template_part( 'head' ); // Подключаем head
?>

<body <?php body_class( 'body' ); // Открываем тег <body> ?>>

	<?php wp_body_open(); ?>

	<section class="wrapper">

		<?php get_template_part( 'header-content' ); // Подключаем контент шапки ?>

		<!-- #Контент сайта (Начало) -->

		<section class="content">
			<section class="content__row wrap">

				<?php
				/**
				 * Проверяем, есть ли виджеты в боковых панелях.
				 * Если есть, выводим их.
				 */
				if ( is_active_sidebar( 'left-sidebar' ) || is_active_sidebar( 'left-sidebar-one' ) ) :
					?>
					<aside class="content__cell content__cell--left">
						<div class="content__sidebar content__sidebar--left">


							<?php dynamic_sidebar( 'left-sidebar' ); // Выводим left-sidebar ?>

							<?php
							if ( is_active_sidebar( 'left-sidebar-one' ) ) : // Если в left-sidebar-one есть виджеты
								?>
								<div class="sidebar--one"><?php dynamic_sidebar( 'left-sidebar-one' ); ?></div>
							<?php endif; ?>
						</div>
					</aside>
				<?php endif; ?>

				<aside class="content__cell content__cell--center">
					<?php
					/**
					 * Выводим хлебные крошки, если это не главная страница и не страница поиска.
					 */
					if ( ! is_front_page() && ! is_search() ) :
						kama_breadcrumbs();
					endif;
					?>