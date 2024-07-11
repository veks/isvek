<?php
/**
 * Comment class.
 *
 * @class   Comment
 * @version 1.0.0
 * @package Isvek\Theme\Walker
 */

namespace Isvek\Theme\Walker;

use Walker_Comment;
use WP_Comment;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Walker\Comment' ) ) {

	/**
	 * Comment class.
	 */
	class Comment extends Walker_Comment {

		/**
		 * Завершает вывод элемента списка.
		 *
		 * @since 1.0.0
		 *
		 * @param string $output Строка вывода содержимого элемента.
		 * @param object $data_object Объект данных элемента.
		 * @param int $depth Глубина вложенности элемента.
		 * @param array $args Дополнительные аргументы для функции.
		 */
		public function end_el( &$output, $data_object, $depth = 0, $args = [] ) {
			if ( ! empty( $args['end-callback'] ) ) {
				ob_start();
				call_user_func(
					$args['end-callback'],
					$data_object, // The current comment object.
					$args,
					$depth
				);
				$output .= ob_get_clean();

				return;
			}
			if ( 'div' === $args['style'] ) {
				$output .= "</div></div>\n";
			} else {
				$output .= "</li>\n";
			}
		}
	}
}
