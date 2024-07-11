<?php
/**
 * Шаблон для отображения всех отдельных постов.
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
		 * Hook: isvek_theme_before_single.
		 *
		 * @hooked isvek_theme_template_single_content - 5
		 */
		do_action( 'isvek_theme_before_single' );

		/**
		 * Hook: isvek_theme_single_content.
		 *
		 * @hooked isvek_theme_template_single_content - 5
		 */
		do_action( 'isvek_theme_single_content' );

		/**
		 * Hook: isvek_theme_after_single.
		 */
		do_action( 'isvek_theme_after_single' );

		/**
		 * Hook: isvek_theme_pagination.
		 *
		 * @hooked isvek_theme_template_pagination - 10
		 */
		do_action( 'isvek_theme_pagination' );

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
