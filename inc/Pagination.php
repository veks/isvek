<?php
/**
 * Pagination class.
 *
 * @class   Pagination
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Pagination' ) ) {

	/**
	 * Pagination class.
	 */
	class Pagination {

		/**
		 * Отображает пагинацию.
		 *
		 * Эта функция генерирует HTML-код пагинации, используя параметры,
		 * заданные в аргументах. Она также добавляет микроразметку Schema.org для SEO.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Массив аргументов для настройки пагинации.
		 *
		 * @return string|void HTML-код пагинации, если 'echo' равно false.
		 */
		public function render( array $args = [] ) {
			global $wp_query;

			$defaults       = [
				'base'               => esc_url_raw( str_replace( 999999999, '%#%', wp_specialchars_decode( esc_url( get_pagenum_link( 999999999, false ) ) ) ) ),
				'format'             => '?page=%#%',
				'total'              => $wp_query->max_num_pages ?? 1,
				'current'            => max( 1, get_query_var( 'paged' ) ),
				'show_all'           => false,
				'end_size'           => 1,
				'mid_size'           => 2,
				'prev_next'          => true,
				'prev_text'          => '<span aria-hidden="false">&laquo;</span>',
				'next_text'          => '<span aria-hidden="false">&raquo;</span>',
				'type'               => 'array',
				'add_args'           => false,
				'add_fragment'       => '',
				'before_page_number' => '',
				'after_page_number'  => '',
				'echo'               => true,
				'aria_label'         => __( 'Навигация страниц', 'isvek' ),
				'pagination_class'   => 'm-0',
			];
			$args           = wp_parse_args( $args, apply_filters( 'isvek_theme_pagination_defaults', $defaults ) );
			$paginate_links = paginate_links( $args );
			$pagination     = '';

			if ( is_array( $paginate_links ) ) {
				$pagination .= "<nav aria-label='{$args['aria_label']}' itemscope itemtype='https://schema.org/SiteNavigationElement' role='navigation'>\n";
				$pagination .= '<ul class="' . array_to_css_classes( [
						'pagination',
						'flex-wrap',
						'justify-content-center',
						$args['pagination_class']
					] ) . '">';

				foreach ( $paginate_links as $link ) {
					$active   = strpos( $link, 'current' );
					$disabled = strpos( $link, 'dots' );
					$link     = str_replace( 'page-numbers', 'page-link', $link );

					if ( $active !== false ) {
						$pagination .= '<li class="page-item active">' . str_replace( '<span ', '<span itemprop="name" ', $link ) . "</li>\n";
					} elseif ( $disabled !== false ) {
						$pagination .= '<li class="page-item disabled">' . $link . "</li>\n";
					} else {
						$pagination .= '<li class="page-item">' . str_replace( '<a', '<a itemprop="url"', $link ) . "</li>\n";
					}
				}

				$pagination .= "</ul></nav>";
			}

			if ( $args['echo'] ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
	}
}
