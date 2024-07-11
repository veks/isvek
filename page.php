<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

get_header();

if ( have_posts() ) {

	while ( have_posts() ) {
		the_post();

		/**
		 * Hook: isvek_theme_before_page.
		 */
		do_action( 'isvek_theme_before_page' );

		/**
		 * Hook: isvek_theme_page_content.
		 *
		 * @hooked isvek_theme_template_page_content - 5
		 */
		do_action( 'isvek_theme_page_content' );


		/**
		 * Hook: isvek_theme_after_page.
		 */
		do_action( 'isvek_theme_after_page' );

		/**
		 * Hook: isvek_theme_before_comments.
		 */
		do_action( 'isvek_theme_before_comments' );

		if ( comments_open() || get_comments_number() ) {

			comments_template();

		}

		/**
		 * Hook: isvek_theme_after_comments.
		 */
		do_action( 'isvek_theme_after_comments' );
	}
}

get_footer();
