<!doctype html>

<html <?php language_attributes(); ?>>

<head>

	<meta http-equiv="Content-type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">

	<title><?php wp_title( ' ', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>

	<meta name="viewport" content="initial-scale=1, maximum-scale=1" />

	<link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon.svg" />
	<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="is_mxda" />
	<link rel="manifest" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/site.webmanifest" />

	<?php wp_head(); ?>

</head>
