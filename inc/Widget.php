<?php
/**
 * Widget class.
 *
 * Виджеты для этой тем.
 *
 * @class   Widget
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Widget' ) ) {

	/**
	 * Widget class.
	 */
	class Widget {

		/**
		 * Конструктор класса.
		 *
		 * Устанавливает действие для инициализации виджетов.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );
			//add_filter( 'dynamic_sidebar_params', [ $this, 'add_widget_classes' ] );
		}

		/**
		 * Регистрация виджетов.
		 *
		 * Функция регистрирует боковые панели слева и справа для виджетов.
		 *
		 * @since 1.0.0
		 */
		public function widgets_init() {
			register_sidebar(
				[
					'id'            => 'isvek-sidebar-left',
					'name'          => __( 'Боковая панель слева', 'isvek' ),
					'description'   => '',
					'before_widget' => '<section id="%1$s" class="card mb-4 widget %2$s shadow-sm">',
					'after_widget'  => '</div></section>',
					'before_title'  => '<h4 class="card-header fs-5 widget-title rounded-top-2">',
					'after_title'   => '</h4><div class="card-body">',
				]
			);

			register_sidebar(
				[
					'id'            => 'isvek-sidebar-right',
					'name'          => __( 'Боковая панель справа', 'isvek' ),
					'description'   => '',
					'before_widget' => '<section id="%1$s" class="card mb-4 widget %2$s shadow-sm">',
					'after_widget'  => '</div></section>',
					'before_title'  => '<h4 class="card-header fs-5 widget-title rounded-top-2">',
					'after_title'   => '</h4><div class="card-body">',
				]
			);
		}

		/**
		 * Добавляет классы виджета.
		 *
		 * Функция принимает параметры виджета и добавляет классы к его контейнеру в соответствии с настройками темы.
		 *
		 * @since 1.0.0
		 *
		 * @param array $params Параметры виджета.
		 *
		 * @return array Возвращает измененные параметры виджета с добавленными классами.
		 */
		public function add_widget_classes( array $params ): array {
			$sidebar    = isvek_theme_get_option( 'sidebar' );
			$classes    = [];
			$widget_id  = $params[0]['widget_id'];
			$sidebar_id = $params[0]['id'];

			if ( ! empty( $sidebar[ $sidebar_id ] ) && array_key_exists( $params[0]['widget_id'], $sidebar[ $sidebar_id ]['widgets'] ) ) {
				$classes[] = join( ' ', $sidebar[ $sidebar_id ]['widgets'][ $widget_id ] );
			}

			if ( empty ( $classes ) ) {
				return $params;
			}

			$params[0]['before_widget'] = preg_replace( '/(class="(.*?)")/i', 'class="$2 ' . join( ' ', $classes ) . '"', $params[0]['before_widget'] );

			return $params;
		}
	}
}
