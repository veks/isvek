<?php
/**
 * Search class.
 *
 * @class   Search
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

use WP_Query;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Search' ) ) {

	/**
	 * Search class.
	 */
	class Search {

		/**
		 * Конструктор класса.
		 */
		public function __construct() {
			if ( wp_doing_ajax() ) {
				add_action( 'wp_ajax_nopriv_isvek_theme_search', [ $this, 'ajax' ] );
				add_action( 'wp_ajax_isvek_theme_search', [ $this, 'ajax' ] );
			}
		}

		/**
		 * Функция для выделения поискового запроса в контенте.
		 *
		 * @since 1.0.0
		 *
		 * @param string $content Контент, в котором выполняется поиск и выделение.
		 *
		 * @return string Измененный контент с выделенным поисковым запросом.
		 */
		public static function get_the_search_mark( string $content ): string {
			global $wp_query;

			if ( '' !== $wp_query->query_vars['s'] ) {
				$search  = sanitize_text_field( wp_unslash( $wp_query->query_vars['s'] ) );
				$content = preg_replace( '/(' . $search . ')/iu', '<mark>$1</mark> ', $content );
			}

			return $content;
		}

		/**
		 * Метод для выполнения AJAX запросов.
		 *
		 * Обрабатывает AJAX запросы для поиска постов и возвращает результат в формате JSON.
		 *
		 * @since 1.0.0
		 */
		public function ajax() {
			if ( wp_verify_nonce( $_POST['security'], 'isvek_theme_search_nonce' ) ) {
				add_filter( 'excerpt_length', function () {
					return 30;
				} );

				add_filter( 'excerpt_more', function () {
					return '...';
				} );

				$query = new WP_Query(
					[
						'posts_per_page' => get_option( 'posts_per_page' ),
						'post_status'    => [ 'publish' ],
						's'              => sanitize_text_field( wp_unslash( $_POST['s'] ) ),
						'post_type'      => 'any',
						'orderby'        => 'post_date',
					]
				);

				$q = [];

				if ( $query->have_posts() ) {
					foreach ( $query->posts as $post ) {
						$q[] = [
							'id'    => $post->ID,
							'title' => get_the_title( $post->ID ),
							'slug'  => home_url( '?s=' . get_the_title( $post->ID ) )
						];
					}

					wp_send_json_success( [ 'query' => $q ] );
				} else {
					wp_send_json_error();
				}
			} else {
				wp_send_json_error();
			}
		}
	}
}
