<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

get_header();

/**
 * Hook: isvek_theme_before_index.
 *
 * @hooked isvek_theme_archive_div_content - 10
 */
do_action( 'isvek_theme_before_index' );

if ( have_posts() ) {

	/**
	 * Hook: isvek_theme_before_index_loop.
	 */
	do_action( 'isvek_theme_before_index_loop' );

	while ( have_posts() ) {

		the_post();

		/**
		 * Hook: isvek_theme_index_loop.
		 *
		 * @hooked isvek_theme_template_single_excerpt - 5
		 */
		do_action( 'isvek_theme_index_loop' );
	}

	/**
	 * Hook: isvek_theme_after_index_loop.
	 */
	do_action( 'isvek_theme_after_index_loop' );

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
 * Hook: isvek_theme_after_index.
 *
 * @hooked isvek_theme_div_close - 10
 */
do_action( 'isvek_theme_after_index' );

get_footer();
