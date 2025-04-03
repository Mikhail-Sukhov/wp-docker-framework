<!-- контент в виде блога -->

<?php
/**
 * Проверяем, есть ли посты для отображения.
 * Если посты есть, выводим их.
 */
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); // Начало цикла
		?>

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">

			<header class="post__header">
				<h2 class="post__title">
					<a class="post__title-href" href="<?php the_permalink(); // Ссылка на пост ?>" title="<?php the_title_attribute(); // Заголовок поста ?>"><?php the_title(); ?></a>
				</h2>
			</header>

			<section class="post__content">

				<?php
				if ( has_post_thumbnail() && ! is_singular() ) : // Если Миниатюра Поста существует
					?>
					<div class="post__image">
						<a href="<?php the_permalink(); // Ссылка на пост ?>" title="<?php the_title_attribute(); // Заголовок поста ?>">
							<?php the_post_thumbnail( array( 999, 128, true ), array() ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php
				if ( has_post_thumbnail() ) :
					?>
					<div class="post__text post__text--img">
				<?php else : ?>
					<div class="post__text">
				<?php endif; ?>

					<?php
					if ( ( is_home() || is_archive() ) && ! is_sticky() ) : // Если Главная или Архив
						?>
						<?php the_excerpt(); // Краткое содержание поста (без форматирования) ?>
						<a href="<?php the_permalink(); // Ссылка на пост ?>" class="post__readmore"><?php echo esc_html__( 'Readmore...', '<%= theme %>' ); ?></a>
					<?php else : ?>
						<?php the_content(); // Полное содержание поста ?>
					<?php endif; ?>
				</div>

			</section>

			<?php edit_post_link( '', '', '', '', 'post__edit' ); ?>

			<footer class="post__footer">

				<section class="meta">

					<div class="meta__cell meta__cell--date">
						<div class="meta__box">
							<span class="meta__icon meta__icon--date"></span>
							<span class="meta__text"><?php the_time( 'j.M.y' ); // Дата публикации ?></span>
						</div>
					</div>

					<?php
					if ( ! is_page() ) :
						?>
						<div class="meta__cell meta__cell--category">
							<div class="meta__box">
								<span class="meta__icon meta__icon--category"></span>
								<span class="meta__text"><?php the_category( ', ', 'multiple' ); // Категория поста ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php the_tags( /* Метки */ '
						<div class="meta__cell meta__cell--tags">
							<div class="meta__box">
								<span class="meta__icon meta__icon--tags"></span>
								<span class="meta__text">', ', ', '</span>
							</div>
						</div>
					' ); ?>

					<?php
					if ( comments_open() ) :
						?>
						<div class="meta__cell meta__cell--comment">
							<div class="meta__box">
								<span class="meta__icon meta__icon--comment"></span>
								<span class="meta__text"><?php comments_popup_link( '0', '1', '%' ); ?></span>
							</div>
						</div>
					<?php endif; ?>

				</section>

			</footer>

		</article>

	<?php
	endwhile;
else :
	?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">
		<h2><?php echo esc_html__( 'There are no posts', '<%= theme %>' ); ?></h2>
	</article>

<?php endif; ?>