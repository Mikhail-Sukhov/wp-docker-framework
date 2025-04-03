<?php

query_posts(array(
	"cat" => 1, // id категории
	//"orderby" => "rand", // сортировка
	"posts_per_page" => 10, // количество постов
));


if ( ! function_exists( '<%= theme %>_rebuild_theme_post_material' ) ) {
	function <%= theme %>_rebuild_theme_post_material($classes) {
		// Очищаем стандартные классы
		$classes = [];
		// получает количество постов на странице
		$col = get_query_var("posts_per_page" );

		if ( $col <= 4 ) {
			$classes[] = "post post--col-{$col}";
		} else {
			$classes[] = "post post--col-material";
		}
		return $classes;
	}
}
add_filter('post_class', '<%= theme %>_rebuild_theme_post_material');

?>

<!-- Статьи слайдер -->

<section class="content__item content__item--material" id="material" data-sal="fade">

	<section class="material">

		<div class="material__title-bg">
			<h2 class="material__title">Мои работы:</h2>
		</div>

		<!-- Контейнер слайдера -->
		<div class="glide glide--post material__row">
			<div class="glide__track" data-glide-el="track">
				<ul class="glide__slides material__slides">

					<?php if (have_posts()) : while (have_posts()) : the_post(); //Начало цикла ?>

						<li class="glide__slide">
							<article <?php post_class() ?> id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">

								<header class="post__header">
									<a class="post__title-href" href="<?php the_permalink(); //Ссылка на пост ?>" title="<?php the_title_attribute(); //Заголовок поста ?>">
										<h2 class="post__title">
											<?php the_title(); ?>
										</h2>
									</a>
								</header>

								<section class="post__content--material">

									<?php if ( has_post_thumbnail() && !is_singular() ) : // Если Миниатюра Поста существует ?>
										<div class="post__image">
											<a href="<?php the_permalink(); //Ссылка на пост ?>" title="<?php the_title_attribute(); //Заголовок поста ?>" >
												<?php the_post_thumbnail( array(999,128, true), array() ); ?>
											</a>
										</div>
									<?php endif; // Конец Если Миниатюра Поста существует ?>

									<?php if ( has_post_thumbnail() ) :?>
										<div class="post__text post__text--img">
									<?php else : ?>
										<div class="post__text ">
									<?php endif; ?>

										<?php if ( ( is_home() || is_archive() ) && ( ! is_sticky() ) ) : //Если Главная или Архив ?>

											<?php the_excerpt(); // Краткое содержание поста(без форматирования) ?>

											<a href="<?php the_permalink(); // Ссылка на пост ?>" class="post__readmore"><?php echo esc_html__( 'Readmore...', '<%= theme %>' ); ?></a>

										<?php else : //Если нет(Если Главная или Архив) ?>

											<?php the_content(); //Полное содержание поста ?>

										<?php endif; //Конец условия(Если Главная или Архив) ?>
										</div>

								</section>

								<?php edit_post_link( '', '', '', '', 'post__edit' ); ?>

							</article>
						</li>

					<?php endwhile; else : //Конец цикла ?>

						<li class="glide__slide">
							<article <?php post_class() ?> id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">
								<h2><?php echo esc_html__( 'There are no posts', '<%= theme %>' ); ?></h2>
							</article>
						</li>

					<?php endif; ?>

				</ul>
			</div>

			<!-- Контроллеры слайдера -->
			<div class="glide__arrows" data-glide-el="controls">
				<button class="glide__arrow glide__arrow--left icon-left-2" data-glide-dir="<"></button>
				<button class="glide__arrow glide__arrow--right icon-right-2" data-glide-dir=">"></button>
			</div>
		</div>

	</section>

</section>