<?php
/**
 * Шаблон для отображения футера.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

	/**
	 * Hook: isvek_theme_after_main.
	 *
	 * @hooked isvek_theme_div_close - 5
	 * @hooked isvek_theme_sidebar_right - 6
	 * @hooked isvek_theme_div_close - 7
	 * @hooked isvek_theme_div_close - 8
	 * @hooked isvek_theme_main_close - 9
	 */
	do_action( 'isvek_theme_after_main' );

	/**
	 * Hook: isvek_theme_after_main.
	 */
	do_action( 'isvek_theme_before_footer' );

	/**
	 * Hook: isvek_theme_footer.
	 *
	 * @hooked isvek_theme_template_footer - 5
	 */
	do_action( 'isvek_theme_footer' );

	/**
	 * Hook: isvek_theme_after_footer.
	 */
	do_action( 'isvek_theme_after_footer' );

	/**
	 * Hook: isvek_theme_after_wrap.
	 *
	 * @hooked isvek_theme_template_scroll_top - 5
	 * @hooked isvek_theme_template_notices_cookies - 6
	 */
	do_action( 'isvek_theme_after_wrap' );

	/**
	 * Hook: isvek_theme_after_outer_wrap.
	 */
	do_action( 'isvek_theme_after_outer_wrap' );

	wp_footer(); ?>

	</body>

</html>
