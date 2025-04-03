<?php

// Настройки шаблона через customizer API
require_once('customizer.php');

// Блоки кода для повторного использования
require_once('inc/index.php');

// Классические виджеты Wordpress
require_once('widget/index.php');

// Настройки редактора Gutenberg
require_once('gutenberg/gutenberg-setting.php');


// Переводы
if ( ! function_exists( 'wpsampletemplate_theme_textdomain' ) ) {
	function wpsampletemplate_theme_textdomain() {
		load_theme_textdomain('wpsampletemplate', get_template_directory() . '/languages');
	}
}
add_action('after_setup_theme', 'wpsampletemplate_theme_textdomain');


/*******************************************************************************************************************************************\
					 ||||||  ||  ||    ||| ||     |||||| |||||  ||   ||
					|  ||  | ||  ||   | || ||       ||   ||  || ||   ||
					|  ||  | || |||  |  || ||||     ||   |||||| |||| ||
					 ||||||  ||| || ||  || ||  ||   ||   ||     || | ||
					   ||    ||  || ||  || |||||    ||   ||     |||| ||
\*******************************************************************************************************************************************/

// Настройка количества страниц для разных их видов
if ( ! function_exists( 'wpsampletemplate_custom_posts_per_page' ) ) {
	function wpsampletemplate_custom_posts_per_page($query) {

		if ( !is_admin() && $query->is_main_query() ) {

			if ( $query->is_home() ) {
				$query->set('posts_per_page', get_theme_mod( 'home_page_number', 5) );
			}

			if ( $query->is_search() ) {
				$query->set('posts_per_page', get_theme_mod( 'search_page_number', 5 ) );
			}

			if ( $query->is_archive() ) {
				if ( $query->is_category() ) {
					$query->set('posts_per_page', get_theme_mod( 'archive_page_number', 5 ) );
				}
				else {
					$query->set('posts_per_page', get_theme_mod( 'category_page_number', 5 ) );
				}
			}
		}
	}
}
add_action('pre_get_posts','wpsampletemplate_custom_posts_per_page');


// добавляет post_coll в post_class() необходимо для системы колонок темы
if ( ! function_exists( 'wpsampletemplate_rebuild_theme_post_classes' ) ) {
	function wpsampletemplate_rebuild_theme_post_classes($classes) {

		if ( is_singular() ) {
			$classes[] = 'post--singular';
			if ( is_page() || is_attachment() ) {
				$classes[] = 'post';
			}
		}
		if ( is_home() ) {
			$classes[] = get_theme_mod( 'home_page_col', 'post--col-2' );
		}
		if ( is_search() ) {
			$classes[] = get_theme_mod( 'search_page_col', 'post--col-2' );
		}
		if ( is_archive() ) {
			if ( is_category() ) {
				$classes[] = get_theme_mod( 'category_page_col', 'post--col-2' );
			}
			else {
				$classes[] = get_theme_mod( 'archive_page_col', 'post--col-2' );
			}

		}
		return $classes;
	}
}
add_filter('post_class', 'wpsampletemplate_rebuild_theme_post_classes');


// Убирает стили у виджета "Последние комментарии"
if ( ! function_exists( 'wpsampletemplate_my_remove_recent_comments_style' ) ) {
	function wpsampletemplate_my_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}
add_action('widgets_init', 'wpsampletemplate_my_remove_recent_comments_style');


// Заменяет "[..]" у the_excerpt на "..." в сокращении текста поста
if ( ! function_exists( 'wpsampletemplate_post_excerpt_more' ) ) {
	function wpsampletemplate_post_excerpt_more($more) {
		return '...';
	}
}
add_filter('excerpt_more', 'wpsampletemplate_post_excerpt_more');


// Количество символов у excerpt
if ( ! function_exists( 'wpsampletemplate_new_excerpt_length' ) ) {
	function wpsampletemplate_new_excerpt_length($length) {
		return 25;
	}
}
add_filter('excerpt_length', 'wpsampletemplate_new_excerpt_length');


// удаляет H2 из шаблона пагинации и корректирует вывод
if ( ! function_exists( 'wpsampletemplate_my_navigation_template' ) ) {
	function wpsampletemplate_my_navigation_template( $template, $class ) {
		return '
			<nav class="navigation %1$s">
				<div class="nav-links">%3$s</div>
			</nav>
			';
	}
}
add_filter('navigation_markup_template', 'wpsampletemplate_my_navigation_template', 10, 2 );


// Очистка лишних тегов в head
if ( ! function_exists( 'wpsampletemplate_clean_wp_header' ) ) {
	function wpsampletemplate_clean_wp_header() {
		remove_action( 'wp_head', 'wp_generator'                           );
		remove_action( 'wp_head', 'rsd_link'                               );
		remove_action( 'wp_head', 'feed_links', 2                          );
		remove_action( 'wp_head', 'feed_links_extra', 3                    );
		remove_action( 'wp_head', 'wlwmanifest_link'                       );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0            );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7        );
		remove_action( 'wp_print_styles', 'print_emoji_styles'             );
	}
}
add_action('init', 'wpsampletemplate_clean_wp_header');


/*******************************************************************************************************************************************\
					||   | |||||  ||  || ||  ||
					||| || ||     ||| || ||  ||
					|| | | ||||   || ||| ||  ||
					||   | ||     ||  || ||  ||
					||   | |||||  ||  ||  ||||
\*******************************************************************************************************************************************/

// Изменяет шаблон меню
if ( ! class_exists( 'wpsampletemplate_MyNavMenu' ) ) {

	class wpsampletemplate_MyNavMenu extends Walker_Nav_Menu {

		// function start_lvl( &$output, $depth ) {
		public function start_lvl( &$output, $depth = 0, $args = null ) {

			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"menu__sub\">\n";
		}

		// function start_el( &$output, $item, $depth, $args ) {
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

			global $wp_query;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			if ( in_array( 'menu-item', $item->classes ) ) {
				$classes[] = 'item';
			}

			if ( in_array( 'menu-item-has-children', $item->classes ) ) {
				$classes[] = 'parent';
			}

			if (
				in_array( 'current-menu-item',     $item->classes ) ||
				in_array( 'current-menu-parent',   $item->classes ) ||
				in_array( 'current-menu-ancestor', $item->classes )
				)
			{
				$classes[] = 'current';
			}

			// Удаляет лишние классы
			$classes = array_diff( $classes, array(
				'menu-item',
				'current-menu-ancestor',
				'current-menu-parent',
				'menu-item-has-children',
				'current-menu-item',
				'menu-item-type-post_type',
				'menu-item-object-page',
				'page_item',
				'current_page_item',
				'page-item-' . $item->object_id,
				'current-page-ancestor',
				'current-page-parent',
				'current_page_parent',
				'current_page_ancestor',
				'menu-item-type-taxonomy',
				'menu-item-object-category',
			) );

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';


			$output .= $indent . '<li' . $value . $class_names .'>';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			$item_output .= '<a class="menu__href"'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}


// Глобальные настройки для меню
if ( ! function_exists( 'wpsampletemplate_my_wp_nav_menu_args' ) ) {
	function wpsampletemplate_my_wp_nav_menu_args( $args = '' ) {
		$args['container']  = false;
		$args['items_wrap'] = '<ul class="%2$s %1$s">%3$s</ul>';
		$args['walker']     = new wpsampletemplate_MyNavMenu();
		return $args;
	}
}
add_filter( 'wp_nav_menu_args', 'wpsampletemplate_my_wp_nav_menu_args' );



/*******************************************************************************************************************************************\
					|||||   ||||  ||||||  ||||     |||  ||||  |||||  ||  || ||  ||
					    || ||  || ||     ||  ||   | || ||  || ||  || || ||  ||  ||
					  |||  |||||| ||     ||  ||  |  || ||  || |||||  ||||   || |||
					    || ||  || ||     ||  || ||  || ||  || ||  || || ||  ||| ||
					|||||  ||  || ||      ||||  ||  ||  ||||  |||||  ||  || ||  ||
\*******************************************************************************************************************************************/

// Настройки Заголовков виджета
//-----------------------------------------------------------------------------------------------------//

// Ссылка для заголовка виджета ( [url=http://]Заголовок[/url] )
if ( ! function_exists( 'wpsampletemplate_allow_url_in_widget' ) ) {
	function wpsampletemplate_allow_url_in_widget($title) {
		return preg_replace('/\[url=(.+)\](.+)\[\/url\]/i', '<a href="$1">$2</a>', $title);
	}
}
add_filter('widget_title', 'wpsampletemplate_allow_url_in_widget');


// Добавляет иконку для заголовка виджета [i=]Заголовок
if ( ! function_exists( 'wpsampletemplate_allow_widget_icon' ) ) {
	function wpsampletemplate_allow_widget_icon($title) {
		return preg_replace('/\[i=(.+)\](.+)/i', '<span class="$1"></span>$2', $title);
	}
}
add_filter('widget_title', 'wpsampletemplate_allow_widget_icon');


// Добавляет class для заголовка виджета [class=]Заголовок
if ( ! function_exists( 'wpsampletemplate_allow_widget_class' ) ) {
	function wpsampletemplate_allow_widget_class($title) {
		return preg_replace('/\[class=(.+)\](.+)/', '<span class="$1">$2</span>', $title);
	}
}
add_filter('widget_title', 'wpsampletemplate_allow_widget_class');


// Добавляет иконку вместо заголовка виджета [ii=]
if ( ! function_exists( 'wpsampletemplate_allow_widget_icon_1' ) ) {
	function wpsampletemplate_allow_widget_icon_1($title) {
		return preg_replace('/\[ii=(.+)\](.+)/', '<span class="$1"></span>', $title);
	}
}
add_filter('widget_title', 'wpsampletemplate_allow_widget_icon_1');


// Скрыть заголовок виджета !
if ( ! function_exists( 'wpsampletemplate_hide_widget_title' ) ) {
	function wpsampletemplate_hide_widget_title( $title ) {
		if ( empty( $title ) ) return '';
		if ( $title[0] == '!' ) return '';
		return $title;
	}
}
add_filter( 'widget_title', 'wpsampletemplate_hide_widget_title' );


// br Для заголовков виджета <br>
if ( ! function_exists( 'wpsampletemplate_br_widget_title' ) ) {
	function wpsampletemplate_br_widget_title($title) {
		return preg_replace('/\<br\>(.+)/i', '<br>$1', $title);
	}
}
add_filter('widget_title', 'wpsampletemplate_br_widget_title');



// Настройки для меню
//-----------------------------------------------------------------------------------------------------//

// Добавляет иконку к пункту меню [i=]меню
if ( ! function_exists( 'wpsampletemplate_allow_menu_icon' ) ) {
	function wpsampletemplate_allow_menu_icon($title) {
		return preg_replace('/\[i=(.+)\](.+)/i', '<span class="$1"></span>$2', $title);
	}
}
add_filter('wp_nav_menu', 'wpsampletemplate_allow_menu_icon');


// br Для меню <br>
if ( ! function_exists( 'wpsampletemplate_allow_br_menu' ) ) {
	function wpsampletemplate_allow_br_menu($title) {
		return preg_replace('/\<br\>(.+)/i', '<br>$1', $title);
	}
}
add_filter('wp_nav_menu', 'wpsampletemplate_allow_br_menu');



/*******************************************************************************************************************************************\
					||   |  ||||  |||||  |||||| ||  ||  ||||    |||   ||   ||
					||   | ||  || ||  ||   ||   || ||  ||  ||  || ||  ||   ||
					|| | | ||  || ||||||   ||   ||||   ||  ||  || ||  |||| ||
					|| | | ||  || ||       ||   || ||  ||  || ||||||| || | ||
					||||||  ||||  ||       ||   ||  ||  ||||  |     | |||| ||
\*******************************************************************************************************************************************/

// // Телефоны
// //-----------------------------------------------------------------------------------------------------//

// // tel1
// if ( ! function_exists( 'wpsampletemplate_getting_tel1' ) ) {
// 	function wpsampletemplate_getting_tel1() {
// 		return get_theme_mod( 'about_tel_1', '[шорткод телефона 1]' );
// 	}
// }
// add_shortcode('tel1', 'wpsampletemplate_getting_tel1');


// // tel2
// if ( ! function_exists( 'wpsampletemplate_getting_tel2' ) ) {
// 	function wpsampletemplate_getting_tel2() {
// 		return get_theme_mod( 'about_tel_2', '[шорткод телефона 2]' );
// 	}
// }
// add_shortcode('tel2', 'wpsampletemplate_getting_tel2');



// // Адрес
// //-----------------------------------------------------------------------------------------------------//
// if ( ! function_exists( 'wpsampletemplate_getting_adress' ) ) {
// 	function wpsampletemplate_getting_adress() {
// 		return get_theme_mod( 'about_adress', '[шорткод адреса]'  );
// 	}
// }
// add_shortcode('adress', 'wpsampletemplate_getting_adress');



// // Почта
// //-----------------------------------------------------------------------------------------------------//
// if ( ! function_exists( 'wpsampletemplate_getting_mail' ) ) {
// 	function wpsampletemplate_getting_mail() {
// 		return get_theme_mod( 'about_mail', '[шорткод почты]' );
// 	}
// }
// add_shortcode('mail', 'wpsampletemplate_getting_mail');


// // vk
// //-----------------------------------------------------------------------------------------------------//
// if ( ! function_exists( 'wpsampletemplate_getting_vk' ) ) {
// 	function wpsampletemplate_getting_vk() {
// 		return get_theme_mod( 'about_vk', '[шорткод vk]' );
// 	}
// }
// add_shortcode('vk', 'wpsampletemplate_getting_vk');


// // tg
// //-----------------------------------------------------------------------------------------------------//
// if ( ! function_exists( 'wpsampletemplate_getting_tg' ) ) {
// 	function wpsampletemplate_getting_tg() {
// 		return get_theme_mod( 'about_tg', '[шорткод Telegram]' );
// 	}
// }
// add_shortcode('tg', 'wpsampletemplate_getting_tg');


// // wa
// //-----------------------------------------------------------------------------------------------------//
// if ( ! function_exists( 'wpsampletemplate_getting_wa' ) ) {
// 	function wpsampletemplate_getting_wa() {
// 		return get_theme_mod( 'about_wa', '[шорткод WhatsApp]' );
// 	}
// }
// add_shortcode('wa', 'wpsampletemplate_getting_wa');


// Шотркоды Общие настройки
//-----------------------------------------------------------------------------------------------------//
if (!function_exists('wpsampletemplate_getting_about')) {
	function wpsampletemplate_getting_about($atts) {
		 
		 // Обрабатываем позиционный параметр (например: [about tel_1])
		 if (isset($atts[0])) {
			  $atts['about'] = $atts[0];
			  unset($atts[0]);
		 }

		 $atts = shortcode_atts(array(
			  'about' => ''
		 ), $atts, 'about');

		 return get_theme_mod("about_{$atts['about']}", "[шорткод Общие настройки]");
	}
}
add_shortcode('about', 'wpsampletemplate_getting_about');


// Шотркоды услуг
//-----------------------------------------------------------------------------------------------------//

// шорткод название услуги [price_name get=slug1]
if ( ! function_exists( 'wpsampletemplate_get_price_name' ) ) {
	function wpsampletemplate_get_price_name( $atts ) {

		if (isset($atts[0])) {
			$atts['about'] = $atts[0];
			unset($atts[0]);
		}

		$atts = shortcode_atts( array(
			'get' => ''
		), $atts );

		return get_theme_mod( "price_name_{$atts['get']}", "{$atts['get']} ");
	}
}
add_shortcode('price_name', 'wpsampletemplate_get_price_name');



// шорткод цены услуги [price_num get=slug1] 
if ( ! function_exists( 'wpsampletemplate_get_price_number' ) ) {
	function wpsampletemplate_get_price_number( $atts ) {

		if (isset($atts[0])) {
			$atts['about'] = $atts[0];
			unset($atts[0]);
		}

		$atts = shortcode_atts( array(
			'get' => ''
		), $atts );

		return get_theme_mod( "price_number_{$atts['get']}", "{$atts['get']}" );
	}
}
add_shortcode('price_num', 'wpsampletemplate_get_price_number');



// Шорткод выводит ссылку на услугу [price_url get=slug1]текст[/price_url]
if ( ! function_exists( 'wpsampletemplate__get_price_url' ) ) {
	function wpsampletemplate_get_price_url( $atts, $shortcode_content = null ) {

		if (isset($atts[0])) {
			$atts['about'] = $atts[0];
			unset($atts[0]);
		}

		$atts = shortcode_atts( array(
			'get' => '',
		), $atts );

		$b = get_theme_mod( "price_url_{$atts['get']}", '#111' );
		return '<a href="'.$b.'">'.do_shortcode( $shortcode_content ).'</a>';
	}
}
add_shortcode('price_url', 'wpsampletemplate_get_price_url');


/*******************************************************************************************************************************************\
					|||||  |||||| |||||| ||  ||  ||||  |||||| |||||   ||||  ||  || ||  ||  |||||
					||  || ||     ||     ||  || ||  ||   ||   ||  || ||  || ||  || ||  || ||  ||
					|||||| ||||   ||     || ||| ||       ||   |||||| |||||| ||  || || |||  |||||
					||     ||     ||     ||| || ||  ||   ||   ||     ||  || ||  || ||| || ||  ||
					||     |||||| ||     ||  ||  ||||    ||   ||     ||  ||  ||| | ||  || ||  ||
\*******************************************************************************************************************************************/

// Регистрация сайдбаров
if ( ! function_exists( 'wpsampletemplate_widgets_init' ) ) {
	function wpsampletemplate_widgets_init() {
			
		// Левый сайдбар
		register_sidebar( array(
			'id'            => 'left-sidebar',
			'name'          => esc_html__( 'Left sidebar', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Sidebar for the left column', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="sidebar %2$s">',
			'before_title'  => '<h3 class="sidebar__title">',
			'after_title'   => '</h3><div class="sidebar__box">',
			'after_widget'  => '</div></div>',
		) );


		// Левый совмещённый сайдбар
		register_sidebar( array(
			'id'            => 'left-sidebar-one',
			'name'          => esc_html__( 'Left combined sidebar', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Sidebar for the left combined column', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="sidebar--one__box %2$s">',
			'before_title'  => '<h3 class="sidebar--one__title">',
			'after_title'   => '</h3><div class="sidebar--one__box">',
			'after_widget'  => '</div></div>',
		) );


		// Правый сайдбар
		register_sidebar( array(
			'id'            => 'right-sidebar',
			'name'          => esc_html__( 'The right sidebar', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Sidebar for the right column', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="sidebar %2$s">',
			'before_title'  => '<h3 class="sidebar__title">',
			'after_title'   => '</h3><div class="sidebar__box">',
			'after_widget'  => '</div></div>'
		) );


		// Правый совмещённый сайдбар
		register_sidebar( array(
			'id'            => 'right-sidebar-one',
			'name'          => esc_html__( 'Right combined sidebar', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Sidebar for the right combined column', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="sidebar--one__box %2$s">',
			'before_title'  => '<h3 class="sidebar--one__title">',
			'after_title'   => '</h3><div class="sidebar--one__box">',
			'after_widget'  => '</div></div>',
		) );


		// Сайдбар подвала 1
		register_sidebar( array(
			'id'            => 'footer-sidebar-1',
			'name'          => esc_html__( 'Footer sidebar 1', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Footer sidebar first line', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="footer__cell %2$s">',
			'before_title'  => '<h3 class="footer__title">',
			'after_title'   => '</h3><div class="footer__box">',
			'after_widget'  => '</div></div>'
		) );


		// Сайдбар подвала 2
		register_sidebar( array(
			'id'            => 'footer-sidebar-2',
			'name'          => esc_html__( 'Footer sidebar 2', 'wpsampletemplate' ),
			'description'   => esc_html__( 'Footer  sidebar second line', 'wpsampletemplate' ),
			'before_widget' => '<div id="%1$s" class="footer__cell %2$s">',
			'before_title'  => '<h3 class="footer__title">',
			'after_title'   => '</h3><div class="footer__box">',
			'after_widget'  => '</div></div>'
		) );

	}
}
add_action( 'widgets_init', 'wpsampletemplate_widgets_init' );


// Регистрация меню
if ( ! function_exists( 'wpsampletemplate_menus_init' ) ) {
	function wpsampletemplate_menus_init() {
		register_nav_menus ( array (
				'mobile-menu'           => esc_html__( 'Mobile menu', 'wpsampletemplate' ),
				'top-header-menu'       => esc_html__( 'Top header menu', 'wpsampletemplate' ),
				'fixed-top-header-menu' => esc_html__( 'Fixed top header menu', 'wpsampletemplate' ),
				'bottom-header-menu'    => esc_html__( 'Bottom header menu', 'wpsampletemplate' ),
			) );
	}
}
add_action( 'after_setup_theme', 'wpsampletemplate_menus_init' );


/*******************************************************************************************************************************************\
					||||||  ||||    |||     |||   |||||| |||||  || | || ||  ||  ||||
					||  || ||  ||  || ||   || ||  ||     ||  ||  |||||  || ||  ||  ||
					||  || ||  ||  || ||   || ||  ||||   ||||||   |||   ||||   ||||||
					||  || ||  || ||||||| ||||||| ||     ||      |||||  || ||  ||  ||
					||  ||  ||||  |     | |     | |||||| ||     || | || ||  || ||  ||
\*******************************************************************************************************************************************/

if ( ! function_exists( 'wpsampletemplate_theme_support_init' ) ) {
	function wpsampletemplate_theme_support_init() {

		// Поддержка форматов
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		) );


		// Поддержка Миниатюр
		add_theme_support( 'post-thumbnails' );


		// Поддержка html5
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );


		// Поддержка ссылок
		add_filter( 'pre_option_link_manager_enabled', '__return_true' );


		// Изменение логотипа
		add_theme_support( 'custom-header', array (
			'default-image' => get_template_directory_uri() . '/img/logo.svg',
		) );

	}
}
add_action( 'after_setup_theme', 'wpsampletemplate_theme_support_init' );


/*******************************************************************************************************************************************\
					 ||||   ||||   ||||       ||||||  ||||
					||  || ||     ||     ||       || ||
					||      ||||   ||||           ||  ||||
					||  ||     ||     || ||   ||  ||     ||
					 ||||   ||||   ||||        ||||   ||||
\*******************************************************************************************************************************************/


// функция подключение стилей и скриптов
if ( ! function_exists( 'wpsampletemplate_enqueue_scripts' ) ) {
	function wpsampletemplate_enqueue_scripts() {
		if ( !is_admin() && !is_user_admin() ) {

			// регистрация стилей
			wp_register_style(  'main-css', get_template_directory_uri() . '/css/main.css', array(), '', 'screen' );

			// подключение стилей
			wp_enqueue_style( 'main-css' );
		
			// регистрация скриптов
			wp_register_script( 'main-js', get_template_directory_uri() . '/js/main.js',   array(), '', false );

			// подключение скриптов
			wp_enqueue_script( 'main-js' );

		}
	}
}
add_action( 'wp_enqueue_scripts', 'wpsampletemplate_enqueue_scripts' );


?>