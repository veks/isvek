<?php
/**
 * Хуки темы Isvek theme.
 *
 * @package Isvek\Theme\Hooks
 * @version 1.0.2
 */

/**
 * Wrap
 *
 * @see isvek_theme_template_skip_link
 * @see isvek_theme_template_scroll_top
 * @see isvek_theme_template_notices_cookies
 */
add_action( 'isvek_theme_before_outer_wrap', 'isvek_theme_template_skip_link', 5 );
add_action( 'isvek_theme_after_wrap', 'isvek_theme_template_scroll_top', 5 );
add_action( 'isvek_theme_after_wrap', 'isvek_theme_template_notices_cookies', 6 );

/**
 * Main.
 *
 * @see isvek_theme_div_main
 * @see isvek_theme_div_container
 * @see isvek_theme_template_breadcrumb
 * @see isvek_theme_div_close
 * @see isvek_theme_div_row
 * @see isvek_theme_template_sidebar_left
 * @see isvek_theme_div_col
 * @see isvek_theme_template_sidebar_right
 * @see isvek_theme_main_close
 */
add_action( 'isvek_theme_before_main', 'isvek_theme_div_main', 1, 0 );
add_action( 'isvek_theme_before_main', 'isvek_theme_div_container', 2, 0 );
add_action( 'isvek_theme_before_main', 'isvek_theme_template_breadcrumb', 3, 0 );
add_action( 'isvek_theme_before_main', 'isvek_theme_div_close', 4 );
add_action( 'isvek_theme_before_main', 'isvek_theme_div_container', 5, 0 );
add_action( 'isvek_theme_before_main', 'isvek_theme_div_row', 6 );
add_action( 'isvek_theme_before_main', 'isvek_theme_template_sidebar_left', 7 );
add_action( 'isvek_theme_before_main', 'isvek_theme_div_col', 8 );

add_action( 'isvek_theme_after_main', 'isvek_theme_div_close', 5 );
add_action( 'isvek_theme_after_main', 'isvek_theme_template_sidebar_right', 6 );
add_action( 'isvek_theme_after_main', 'isvek_theme_div_close', 7 );
add_action( 'isvek_theme_after_main', 'isvek_theme_div_close', 8 );
add_action( 'isvek_theme_after_main', 'isvek_theme_main_close', 9 );

/**
 * Header.
 *
 * @see isvek_theme_header
 * @see isvek_theme_template_header
 * @see isvek_theme_header_close
 */
add_action( 'isvek_theme_before_header', 'isvek_theme_header', 5 );
add_action( 'isvek_theme_header', 'isvek_theme_template_header', 5 );
add_action( 'isvek_theme_after_header', 'isvek_theme_header_close', 5 );

/**
 * Pagination.
 *
 * @see isvek_theme_template_pagination
 */
add_action( 'isvek_theme_pagination', 'isvek_theme_template_pagination', 10, 0 );

/**
 * Index.
 *
 * @see isvek_theme_div_container
 * @see isvek_theme_template_single_excerpt
 * @see isvek_theme_div_close
 */
add_action( 'isvek_theme_before_index', 'isvek_theme_div_container', 10 );
add_action( 'isvek_theme_index_loop', 'isvek_theme_template_single_excerpt', 115 );
add_action( 'isvek_theme_after_index', 'isvek_theme_div_close', 10 );

/**
 * Archive.
 *
 * @see isvek_theme_div_container
 * @see isvek_theme_archive_title
 * @see isvek_theme_template_single_excerpt
 * @see isvek_theme_div_close
 */
add_action( 'isvek_theme_before_archive', 'isvek_theme_div_container', 10 );
add_action( 'isvek_theme_before_archive', 'isvek_theme_archive_title', 11 );
add_action( 'isvek_theme_archive_loop', 'isvek_theme_template_single_excerpt', 115 );
add_action( 'isvek_theme_after_archive', 'isvek_theme_div_close', 10 );

/**
 * Single.
 *
 * @see isvek_theme_template_single_content
 */
add_action( 'isvek_theme_single_content', 'isvek_theme_template_single_content', 115 );

/**
 * Page.
 *
 * @see isvek_theme_template_page_content
 */
add_action( 'isvek_theme_page_content', 'isvek_theme_template_page_content', 115 );

/**
 * Footer.
 *
 * @see isvek_theme_template_footer
 */
add_action( 'isvek_theme_footer', 'isvek_theme_template_footer', 115 );
