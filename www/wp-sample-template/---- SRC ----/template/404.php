<?php
/**
 * Шаблон страницы 404.
 *
 * Этот файл отвечает за отображение страницы 404.
 * Он подключает шапку HTML, контент страницы 404 и подвал сайта.
 *
 */

get_template_part( 'head' ); // Подключаем head
?>

<body <?php body_class(); // Открываем тег <body> ?>>

	<?php wp_body_open(); ?>

	<section class="error">

		<section class="error__page">
			<a class="error__img-href" href="<?php echo home_url( '/' ); ?>"><?php echo esc_html__( 'Error 404', '<%= theme %>' ); ?></a>
			<p class="error__caption">
				<span class="error__text"><?php echo esc_html__( 'The page you requested could not be found', '<%= theme %>' ); ?></span>
			</p>
			<p class="error__caption">
				<span class="error__text"><?php echo esc_html__( 'Try switching to', '<%= theme %>' ); ?> <a class="error__home-href" href="<?php echo home_url( '/' ); ?>"><?php echo esc_html__( 'Main page', '<%= theme %>' ); ?></a></span>
			</p>
		</section>

	</section>

	<?php wp_footer(); // Подключаем скрипты подвала ?>

</body>

</html>