<?php

query_posts(array(
	"cat" => 1, // id категории
	"orderby" => "rand", // сортировка
	"posts_per_page" => 5, // количество постов
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

<!-- Статьи -->

<section class="content__item content__item--material">

	<section class="material">

		<div class="material__title-bg">
			<h2 class="material__title">Интересные статьи:</h2>
		</div>

		<div class="material__row">
			<?php get_template_part('content', '' ) ?>
		</div>

	</section>

</section>
