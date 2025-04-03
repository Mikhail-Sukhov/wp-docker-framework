<?php
/**
 * Контент шапки сайта.
 *
 * Этот файл отвечает за отображение контента шапки сайта, включая меню и контактную информацию.
 *
 */
?>

<!-- #Мобильное меню -->

<?php
/**
 * Проверяем, есть ли мобильное меню.
 * Если есть, выводим его.
 */
if ( has_nav_menu( 'mobile-menu' ) ) :
	?>
	<nav class="mobile-menu">

		<input class="mobile-menu__checkbox" type="checkbox" id="mobile-menu" hidden="hidden">
		<label class="mobile-menu__label" for="mobile-menu"></label>

		<div class="mobile-menu__box">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'mobile-menu', // Имя меню
					'fallback_cb'    => '__return_empty_string', // Не выводить меню, если его нету
				)
			);
			?>
		</div>

	</nav>
<?php endif; ?>

<!-- #Горизонтальное меню в шапке -->

<?php
/**
 * Проверяем, есть ли фиксированное горизонтальное меню в шапке.
 * Если есть, выводим его.
 * 
 */
if ( has_nav_menu( 'fixed-top-header-menu' ) ) :
	?>
	<nav class="topmenu topmenu--fixed topmenu--fixed__top">
		<div class="topmenu__box wrap">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'fixed-top-header-menu', // Имя меню
					'fallback_cb'    => '__return_empty_string', // Не выводить меню, если его нету
				)
			);
			?>
		</div>
	</nav>
<?php endif; ?>

<?php
/**
 * Проверяем, есть ли горизонтальное меню в шапке.
 * Если есть, выводим его.
 * 
 */
if ( has_nav_menu( 'top-header-menu' ) ) :
	?>
	<nav class="topmenu">
		<div class="topmenu__box wrap">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'top-header-menu', // Имя меню
					'fallback_cb'    => '__return_empty_string', // Не выводить меню, если его нету
				)
			);
			?>
		</div>
	</nav>
<?php endif; ?>

<!-- #Шапка сайта -->

<header class="header">
	<section class="header__row wrap">

		<section class="header__cell header__cell--logo">
			<a class="logo" href="<?php echo esc_url( home_url() ); ?>">
				<img
					class="logo__img"
					src="<?php header_image(); ?>"
					alt="Логотип" />

					<?php
					if ( get_theme_mod( 'about_slogan' ) ) :
						?>
						<h2 class="logo__slogan"><?php echo esc_html( get_theme_mod( 'about_slogan', 'Слоган' ) ); ?></h2>
					<?php endif; ?>
			</a>
		</section>

		<section class="header__cell header__cell--cont">

			<div class="header-cont">

				<a class="header-cont__href header-cont__href--tel" href="tel:<?php echo esc_attr( get_theme_mod( 'about_tel_1_href' ) ); ?>">
					<?php echo esc_html( get_theme_mod( 'about_tel_1', '8 (123)456-78-90' ) ); ?>
				</a>

				<a class="header-cont__href header-cont__href--tel" href="tel:<?php echo esc_attr( get_theme_mod( 'about_tel_2_href' ) ); ?>">
					<?php echo esc_html( get_theme_mod( 'about_tel_2', '8 (098)765-43-21' ) ); ?>
				</a>

				<a class="header-cont__href header-cont__href--mail" href="mailto:<?php echo esc_attr( get_theme_mod( 'about_mail' ) ); ?>" target="_blank">
					<?php echo esc_html( get_theme_mod( 'about_mail', 'pochta@pochta.loc' ) ); ?>
				</a>

				<a class="header-cont__href header-cont__href--adress" href="<?php echo esc_url( home_url( '/' ) . get_theme_mod( 'about_contact_href' ) ); ?>">
					<?php echo esc_html( get_theme_mod( 'about_adress', 'Адрес' ) ); ?>
				</a>

			</div>

			<?php get_search_form(); // Подключаем форму поиска ?>

		</section>

	</section>
</header>

<!-- #Горизонтальное меню в контенте -->

<?php
if ( has_nav_menu( 'bottom-header-menu' ) ) :
	?>
	<nav class="topmenu">
		<div class="topmenu__box wrap">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'bottom-header-menu', // Имя меню
					'fallback_cb'    => '__return_empty_string', // Не выводить меню, если его нету
				)
			);
			?>
		</div>
	</nav>
<?php endif; ?>