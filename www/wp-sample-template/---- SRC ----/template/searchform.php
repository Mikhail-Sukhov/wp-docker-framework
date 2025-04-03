<?php
/**
 * Форма поиска.
 *
 * Этот файл содержит HTML-код формы поиска, которая используется на сайте.
 * Форма отправляет запрос на главную страницу сайта с параметром поиска.
 *
 */
?>

<div class="searchform">
	<form role="search" method="get" class="searchform__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="searchform__input">
			<input type="text" placeholder="<?php echo esc_html__( 'Search', '<%= theme %>' ); ?>" name="s" id="s" class="searchform__text" />
			<button type="submit" id="searchform__submit" class="searchform__btn"></button>
			<input type="hidden" value="post" name="post_type" />
		</div>
	</form>
</div>