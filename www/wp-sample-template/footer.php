<!-- #Контент сайта (Продолжение) -->

</aside><!-- Конец content-center -->

<?php
/**
 * Проверяем, есть ли виджеты в боковых панелях.
 * Если есть, выводим их.
 */
if ( is_active_sidebar( 'right-sidebar' ) || is_active_sidebar( 'right-sidebar-one' ) ) :
	?>
	<aside class="content__cell content__cell--right">
		<div class="content__sidebar content__sidebar--right">


			<?php dynamic_sidebar( 'right-sidebar' ); // Выводим right-sidebar ?>

			<?php
			if ( is_active_sidebar( 'right-sidebar-one' ) ) : // Если в right-sidebar-one есть виджеты
				?>
				<div class="sidebar--one"><?php dynamic_sidebar( 'right-sidebar-one' ); ?></div>
			<?php endif; ?>
		</div>
	</aside>
<?php endif; ?>

</section><!-- Конец content-row -->
</section><!-- Конец content -->

<!-- #Подвал сайта -->

<?php
/**
 * Проверяем, есть ли виджеты в подвале.
 * Если есть, выводим их.
 */
if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) ) :
	?>
	<footer class="footer">

		<?php
		if ( is_active_sidebar( 'footer-sidebar-1' ) ) : // Если в footer-sidebar-1 есть виджеты
			?>
			<section class="footer__row wrap">
				<?php dynamic_sidebar( 'footer-sidebar-1' ); // Выводим footer-sidebar-1 ?>
			</section>
		<?php endif; ?>

		<?php
		if ( is_active_sidebar( 'footer-sidebar-2' ) ) : // Если в footer-sidebar-2 есть виджеты
			?>
			<section class="footer__row wrap">
				<?php dynamic_sidebar( 'footer-sidebar-2' ); // Выводим footer-sidebar-2 ?>
			</section>
		<?php endif; ?>

	</footer>
<?php endif; ?>

</section><!-- Конец wrapper -->

<?php
/**
 * блок плавающих контактов
 * 
 */
echo get_sticky_contact();
?>

<?php wp_footer(); // Подключаем скрипты подвала ?>

</body>
</html>