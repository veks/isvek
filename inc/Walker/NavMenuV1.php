<?php
/**
 * NavMenu class.
 *
 * @class   NavMenu
 * @version 1.0.0
 * @package Isvek\Theme\Walker
 */

namespace Isvek\Theme\Walker;

use stdClass;
use Walker_Nav_Menu;
use WP_Post;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Walker\NavMenuV1' ) ) {

	/**
	 * NavMenu class.
	 */
	class NavMenuV1 extends Walker_Nav_Menu {

		/**
		 * @var object
		 */
		public object $args;

		/**
		 * Конструктор класса.
		 *
		 * Устанавливает параметры для навигационного меню темы.
		 *
		 * @param array $args Массив параметров для настройки навигационного меню.
		 *
		 * @since 1.0.0
		 *
		 */
		function __construct( array $args = [] ) {
			$defaults = apply_filters( 'isvek_theme_nav_menu_v1_defaults', [
				'active_class'          => 'active',
				'item_class'            => 'nav-item',
				'link_class'            => 'nav-link',
				'dropdown_item_class'   => 'dropdown-item',
				'dropdown_toggle_class' => 'dropdown-toggle',
				'dropdown_menu_class'   => 'dropdown-menu',
				'dropdown_menu_style'   => '',
				'dropdown'              => true,
				'dropdown_class'        => 'dropdown',
				'dropend_class'         => 'dropend',
				'dropdown_toggle_data'  => [
					'data-bs-toggle'     => 'dropdown',
					'data-bs-auto-close' => 'outside',
					'aria-expanded'      => 'false',
					//'data-bs-trigger'    => 'hover',
				]
			] );

			$this->args = (object) wp_parse_args( $args, $defaults );
		}

		/**
		 * Запускает уровень (Level) элемента меню.
		 *
		 * Данная функция добавляет отступы и классы для элемента меню в зависимости от параметров.
		 *
		 * @param stdClass|null $args Объект аргументов функции `wpnavmenu()`.
		 *
		 * @param string &$output Строка содержимого для добавления к выводу.
		 *
		 * @param int $depth Глубина текущего элемента меню. По умолчанию 0.
		 *
		 * @since 1.0.0
		 *
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );

			// Default class.
			$classes[] = $this->args->dropdown_menu_class;

			if ( $this->args->dropdown && $depth > 0 ) {
				$classes[] = 'dropdown-menu-submenu';
			}

			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
			 *
			 * @param stdClass $args An object of `wp_nav_menu()` arguments.
			 *
			 * @since 4.8.0
			 *
			 */
			$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$data        = $this->args->dropdown ? " data-bs-popper='none'" : '';
			$style       = ! empty( $this->args->dropdown_menu_style ) ? " style='{$this->args->dropdown_menu_style}'" : '';

			$output .= "{$n}{$indent}<ul{$class_names}{$data}{$style}>{$n}"; //none static
		}

		/**
		 * Завершает вывод уровня списка.
		 *
		 * Устанавливает HTML-код для закрытия списка (<ul>) на определенном уровне глубины.
		 *
		 * @param int $depth Глубина текущего уровня списка.
		 * @param object $args Аргументы функции.
		 *
		 * @param string &$output Строка с содержимым списка.
		 *
		 * @since 1.0.0
		 *
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			$output .= "$indent</ul>{$n}";
		}

		/**
		 * Начинает выводить элемент навигационного меню в соответствии с HTML стандартами.
		 *
		 * @param int $depth Глубина вложенности элемента меню.
		 * @param stdClass|null $args Аргументы для вывода элемента.
		 * @param int $current_object_id ID текущего объекта.
		 *
		 * @param string $output Строка, в которую добавляется результат вывода элемента.
		 *
		 * @param WP_Post $data_object Объект данных элемента меню.
		 *
		 * @since 1.0.0
		 *
		 */
		public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
			// Restores the more descriptive, specific name for use within this method.
			$menu_item = $data_object;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
			$classes[] = $this->args->item_class;
			$classes[] = 'menu-item-' . $menu_item->ID;

			if ( $this->args->dropdown ) {
				$classes[] = $depth === 0 && $this->has_children ? $this->args->dropdown_class : ( $this->args->dropdown && $depth > 0 && $this->has_children ? $this->args->dropend_class . ' dropdown-submenu' : '' );
			}

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @param WP_Post $menu_item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 *
			 * @since 4.4.0
			 *
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

			/**
			 * Filters the CSS classes applied to a menu item's list item element.
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post $menu_item The current menu item object.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$classes_flip = array_flip( $classes );

			if ( isset( $classes_flip['dropdown-divider'] ) ) {
				unset( $classes_flip['dropdown-divider'] );
			} elseif ( isset( $classes_flip['dropdown-header'] ) ) {
				unset( $classes_flip['dropdown-header'] );
			}

			$classes     = array_keys( $classes_flip );
			$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

			/**
			 * Filters the ID attribute applied to a menu item's list item element.
			 *
			 * @param string $menu_item_id The ID attribute applied to the menu item's `<li>` element.
			 * @param WP_Post $menu_item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

			$li_atts          = array();
			$li_atts['id']    = ! empty( $id ) ? $id : '';
			$li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

			/**
			 * Filters the HTML attributes applied to a menu's list item element.
			 *
			 * @param WP_Post $menu_item The current menu item object.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @param array $li_atts {
			 *     The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
			 *
			 * @type string $class HTML CSS class attribute.
			 * @type string $id HTML id attribute.
			 * }
			 *
			 * @since 6.3.0
			 *
			 */
			$li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
			$li_attributes = $this->build_atts( $li_atts );

			$output .= $indent . '<li' . $li_attributes . '>';

			$atts           = array();
			$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
			$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
			if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
				$atts['rel'] = 'noopener';
			} else {
				$atts['rel'] = $menu_item->xfn;
			}

			if ( ! empty( $menu_item->url ) ) {
				if ( get_privacy_policy_url() === $menu_item->url ) {
					$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
				}

				$atts['href'] = $menu_item->url;
			} else {
				$atts['href'] = '#';
			}

			$atts['aria-current'] = $menu_item->current ? 'page' : '';

			if ( $this->args->dropdown && $this->has_children ) {
				if ( ! empty( $this->args->dropdown_toggle_data ) ) {
					foreach ( $this->args->dropdown_toggle_data as $data => $value ) {
						if ( isset( $data ) && isset( $value ) ) {
							$atts[ $data ] = $value;
						}
					}
				}
			}

			if ( $depth === 0 ) {
				$class[] = $this->args->link_class;
			} else {
				$class[] = $this->args->dropdown_item_class;
			}

			if ( $this->args->dropdown && $this->has_children ) {
				$class[] = $this->args->dropdown_toggle_class;
			}

			if ( $menu_item->current ||
			     $menu_item->current_item_ancestor ||
			     $menu_item->current_item_parent ||
			     in_array( 'current_page_ancestor', $classes, true ) ) {
				$class[] = $this->args->active_class;
			}

			$atts['class'] = array_to_css_classes( $class ?? [] );
			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 * @type string $title Title attribute.
			 * @type string $target Target attribute.
			 * @type string $rel The rel attribute.
			 * @type string $href The href attribute.
			 * @type string $aria -current The aria-current attribute.
			 * }
			 *
			 * @param WP_Post $menu_item The current menu item object.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 */
			$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
			$attributes = $this->build_atts( $atts );

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @param string $title The menu item's title.
			 * @param WP_Post $menu_item The current menu item object.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 *
			 * @since 4.4.0
			 *
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param WP_Post $menu_item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 *
			 * @since 3.0.0
			 *
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
		}

		/**
		 * Завершает вывод элемента списка (</li> и новая строка).
		 *
		 * Использует различные пробельные символы в зависимости от аргументов.
		 *
		 * @param WP_Post $item Текущий элемент меню.
		 * @param int $depth (optional) Глубина вложенности элемента (по умолчанию 0).
		 * @param stdClass $args (optional) Аргументы меню.
		 *
		 * @param string $output Текущий вывод контента.
		 *
		 * @since 1.0.0
		 *
		 */
		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}

		/**
		 * Метод обработки вывода меню по умолчанию в случае отсутствия.
		 *
		 * Этот метод генерирует HTML-код для меню по умолчанию, который будет отображаться, если у текущего пользователя есть права администратора.
		 *
		 * @param array $args Аргументы для генерации меню.
		 *   - container (string): Название контейнера.
		 *   - container_id (string): ID контейнера.
		 *   - container_class (string): Класс контейнера.
		 *   - menu_class (string): Класс меню.
		 *   - menu_id (string): ID меню.
		 *
		 * @since 1.0.0
		 *
		 * @return string|mixed Возвращает HTML-код меню.
		 */
		public static function fallback( array $args ) {
			if ( current_user_can( 'administrator' ) ) {
				$container       = $args['container'];
				$container_id    = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class      = $args['menu_class'];
				$menu_id         = $args['menu_id'];

				$fallback_output = '';
				if ( $container ) {
					$fallback_output .= '<' . esc_attr( $container );
					if ( $container_id ) {
						$fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
					}
					if ( $container_class ) {
						$fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
					}
					$fallback_output .= '>';
				}
				$fallback_output .= '<ul';
				if ( $menu_id ) {
					$fallback_output .= ' id="' . esc_attr( $menu_id ) . '"';
				}
				if ( $menu_class ) {
					$fallback_output .= ' class="' . esc_attr( $menu_class ) . '"';
				}
				$fallback_output .= '>';
				$fallback_output .= '<li class="nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . __( 'Добавить меню', 'isvek' ) . '">' . __( 'Добавить меню', 'isvek' ) . '</a></li>';
				$fallback_output .= '</ul>';
				if ( $container ) {
					$fallback_output .= '</' . esc_attr( $container ) . '>';
				}

				if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
					echo $fallback_output;
				} else {
					return $fallback_output;
				}
			}
		}
	}
}
