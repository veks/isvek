<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<!doctype html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset='<?php bloginfo( 'charset' ); ?>'/>
	<meta name='viewport' content='width=device-width, initial-scale=1'/>
	<meta http-equiv='x-ua-compatible' content='ie=edge'/>
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
	wp_body_open();

	/**
	 * Hook: isvek_theme_before_outer_wrap.
	 */
	do_action( 'isvek_theme_before_outer_wrap' );

	/**
	 * Hook: isvek_theme_before_wrap.
	 */
	do_action( 'isvek_theme_before_wrap' );

	/**
	 * Hook: isvek_theme_before_header.
	 *
	 * @hooked isvek_theme_header - 5
	 */
	do_action( 'isvek_theme_before_header' );

	/**
	 * Hook: isvek_theme_header.
	 *
	 * @hooked isvek_theme_template_header - 5
	 */
	do_action( 'isvek_theme_header' );

	/**
	 * Hook: isvek_theme_after_header.
	 *
	 * @hooked isvek_theme_header_close - 5
	 */
	do_action( 'isvek_theme_after_header' );

	/**
	 * Hook: isvek_theme_before_main.
	 *
	 * @hooked isvek_theme_div_main - 1
	 * @hooked isvek_theme_div_container - 2
	 * @hooked isvek_theme_template_breadcrumb - 3
	 * @hooked isvek_theme_div_close - 4
	 * @hooked isvek_theme_div_container - 5
	 * @hooked isvek_theme_div_row - 6
	 * @hooked isvek_theme_sidebar_left - 7
	 * @hooked isvek_theme_div_col - 8
	 */
	do_action( 'isvek_theme_before_main' );
