<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

get_header();

/**
 * Hook: isvek_theme_before_archive.
 *
 * @hooked isvek_theme_div_container - 10
 * @hooked isvek_theme_archive_title - 11
 */
do_action( 'isvek_theme_before_archive' );

/**
 * Hook: isvek_theme_before_archive_loop.
 */
do_action( 'isvek_theme_before_archive_loop' );

if ( have_posts() ) {

	while ( have_posts() ) {

		the_post();

		/**
		 * Hook: isvek_theme_archive_loop.
		 *
		 * @hooked isvek_theme_template_single_excerpt - 5
		 */
		do_action( 'isvek_theme_archive_loop' );
	}

	/**
	 * Hook: isvek_theme_after_archive_loop.
	 */
	do_action( 'isvek_theme_after_archive_loop' );

	/**
	 * Hook: isvek_theme_pagination.
	 *
	 * @hooked isvek_theme_template_pagination - 10
	 */
	do_action( 'isvek_theme_pagination' );

} else {

	get_template_part( 'template-parts/none' );

}

/**
 * Hook: isvek_theme_after_archive.
 *
 * @hooked isvek_theme_div_close - 10
 */
do_action( 'isvek_theme_after_archive' );

get_footer();
