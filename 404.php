<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

status_header( 404 );

get_header();

get_template_part( 'template-parts/404' );

get_footer();
