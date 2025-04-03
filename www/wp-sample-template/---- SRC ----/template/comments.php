<?php
/**
 * Файл шаблона комментариев.
 *
 * Этот файл отвечает за отображение комментариев и формы для их добавления.
 *
 */

if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

if ( ! empty( get_post()->post_password ) ) {
	if ( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] != get_post()->post_password ) {
		?>

		<p class="nocomments"><?php echo esc_html__( 'Enter the password', '<%= theme %>' ); ?></p>

		<?php
		return;
	}
}

$oddcomment = '';
?>

<?php if ( comments_open() ) : // Если комментарии разрешены ?>

	<section class="m-comment" id="comments">

		<!-- #Комментарии -->

		<?php if ( $comments ) : // Если есть комментарии ?>
			<div class="m-comment__list">
				<h2 class="m-comment__list-title"><?php echo esc_html__( 'Comments', '<%= theme %>' ); ?></h2>
				<?php wp_list_comments( 'avatar_size=64' ); // Выводит комментарии ?>
			</div>
		<?php endif; ?>

		<!-- #Форма комментариев -->

		<div class="m-comment__form">

			<div class="m-comment__reply">
				<small><?php cancel_comment_reply_link(); // Отменить ответ ?></small>
			</div>

			<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : // Если незарегистрированным запрещено комментировать ?>

				<div class="m-comment__err-mes">
					<p id="respond"><?php echo esc_html__( 'Please', '<%= theme %>' ); ?>, <a href="<?php echo get_option( 'siteurl' ); ?>/wp-login.php?redirect_to=<?php echo urlencode( get_permalink() ); ?>"><?php echo esc_html__( 'register', '<%= theme %>' ); ?></a> <?php echo esc_html__( 'to comment.', '<%= theme %>' ); ?></p>
				</div>

			<?php else : // Если нет (Если незарегистрированным запрещено комментировать) ?>

				<h2 class="m-comment__form-title" id="respond"><?php echo esc_html__( 'Post a comment', '<%= theme %>' ); ?></h2>

				<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" class="form">

					<?php if ( is_user_logged_in() ) : // Если пользователь зарегистрирован ?>

						<div class="m-comment__hello-mes">
							<p><?php echo esc_html__( 'Hello', '<%= theme %>' ); ?>, <a href="<?php echo get_option( 'siteurl' ); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Выйти">Выход &raquo;</a></p>
						</div>

					<?php else : // Если нет (Если пользователь зарегистрирован) ?>

						<!--[if IE 9]><p>Введите имя*</p><![endif]-->
						<div class="m-comment__author">
							<label class="m-comment__icon-author" for="author"></label>
							<input class="m-comment__input" type="text" name="author" id="author" placeholder="Введите имя" required>
						</div>

						<!--[if IE 9]><p>Введите email*</p><![endif]-->
						<div class="m-comment__email">
							<label class="m-comment__icon-mail" for="email"></label>
							<input class="m-comment__input" type="email" name="email" id="email" placeholder="Введите email" required>
						</div>

						<!--[if IE 9]><p>Введите сайт</p><![endif]-->
						<div class="m-comment__url">
							<label class="m-comment__icon-url" for="url"></label>
							<input class="m-comment__input" type="text" name="url" id="url" placeholder="Введите сайт">
						</div>

					<?php endif; ?>

					<!--[if IE 9]><p>Введите текст сообщения</p><![endif]-->
					<textarea class="m-comment__textarea" id="comment" name="comment" placeholder="Введите текст сообщения"></textarea>

					<?php if ( function_exists( 'checkbot_show' ) ) { checkbot_show(); } ?>

					<div class="m-comment__btn-cell">
						<input name="submit" type="submit" value="Отправить" class="m-comment__submit" />
						<?php comment_id_fields(); ?>
					</div>

					<?php do_action( 'comment_form', get_the_ID() ); ?>

				</form>

			<?php endif; ?>

		</div>

	</section>

<?php else : // Если нет (Если комментарии разрешены) ?>
	<section class="m-comment" id="comments">
		<div class="m-comment__err-mes">
			<p><?php echo esc_html__( 'Comments on this post are closed!', '<%= theme %>' ); ?></p>
		</div>
	</section>
<?php endif; ?>