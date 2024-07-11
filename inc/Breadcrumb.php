<?php
/**
 * Breadcrumb class.
 *
 * @class   Breadcrumb
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Breadcrumb' ) ) {

	/**
	 * Breadcrumb class.
	 */
	class Breadcrumb {

		/**
		 * Хлебная крошка.
		 *
		 * @var array
		 */
		protected array $crumbs = [];

		/**
		 * Позиция.
		 *
		 * @return int
		 */
		protected int $position = 1;

		/**
		 * Аргументы.
		 *
		 * @return array
		 */
		protected object $args;

		/**
		 * Конструктор класса.
		 *
		 * Этот конструктор принимает массив аргументов, которые могут быть переопределены
		 * с помощью фильтра 'isvek_theme_breadcrumb_defaults'. Значения по умолчанию включают
		 * различные параметры для контейнера навигационной цепочки и самой навигационной цепочки.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Массив аргументов для настройки навигационной цепочки.
		 *
		 */
		public function __construct( array $args = [] ) {
			$this->args = (object) wp_parse_args( $args, apply_filters(
				'isvek_theme_breadcrumb_defaults',
				[
					'container'                    => 'nav',
					'container_class'              => '',
					'container_id'                 => '',
					'container_attribute'          => [
						'aria-label' => __( 'Навигационная цепочка', 'isvek' ),
					],
					'before'                       => '',
					'after'                        => '',
					'breadcrumb_attribute'         => [],
					'breadcrumb_class'             => 'breadcrumb breadcrumb-expand-lg m-0',
					'breadcrumb_item_class'        => 'breadcrumb-item',
					'breadcrumb_item_a_class'      => '',
					'breadcrumb_item_active_class' => 'active',
					'home_name'                    => __( 'Главная', 'isvek' ),
					'home_url'                     => get_home_url(),
					'echo'                         => true,
				]
			) );

			$this->generate();
		}

		/**
		 * Отображает навигационную цепочку.
		 *
		 * Эта функция генерирует HTML-код навигационной цепочки, используя параметры,
		 * заданные в конструкторе. Она также добавляет микроразметку Schema.org для SEO.
		 *
		 * @since 1.0.0
		 *
		 * @return string|void HTML-код навигационной цепочки, если 'echo' равно false.
		 */
		public function render() {
			$html                    = '';
			$container_attribute     = '';
			$breadcrumb_attribute    = '';
			$container_class         = $this->args->container_class ? ' class="' . esc_attr( $this->args->container_class ) . '"' : '';
			$container_id            = $this->args->container_id ? ' id="' . esc_attr( $this->args->container_id ) . '"' : '';
			$breadcrumb_class        = $this->args->breadcrumb_class ? ' class="' . esc_attr( $this->args->breadcrumb_class ) . '"' : '';
			$breadcrumb_item_a_class = $this->args->breadcrumb_item_a_class ? ' class="' . esc_attr( $this->args->breadcrumb_item_a_class ) . '"' : '';
			$position                = $this->position + 1;

			if ( ! empty( $this->get_breadcrumb() ) ) {
				if ( ! empty( $this->args->container_attribute ) ) {
					foreach ( $this->args->container_attribute as $attribute => $value ) {
						if ( ! in_array( $attribute, [ 'class', 'id' ], true ) ) {
							if ( ! empty( $value ) ) {
								$container_attribute .= esc_attr( $attribute ) . "='" . esc_attr( $value ) . "'" . ' ';
							} else {
								$container_attribute .= esc_attr( $attribute ) . ' ';
							}
						}
					}
				}

				if ( ! empty( $this->args->breadcrumb_attribute ) ) {
					foreach ( $this->args->breadcrumb_attribute as $attribute => $value ) {
						if ( ! in_array( $attribute, [ 'class', 'id' ], true ) ) {
							if ( ! empty( $value ) ) {
								$breadcrumb_attribute .= esc_attr( $attribute ) . "='" . esc_attr( $value ) . "'" . ' ';
							} else {
								$breadcrumb_attribute .= esc_attr( $attribute ) . ' ';
							}
						}
					}
				}

				$html .= sprintf(
					'%1$s<%2$s %3$s %4$s %5$s>',
					$this->args->before,
					$this->args->container,
					$container_id,
					$container_class,
					$container_attribute
				);
				$html .= sprintf(
					'<ol %1$s %2$s itemscope="" itemtype="https://schema.org/BreadcrumbList">',
					$breadcrumb_class,
					$breadcrumb_attribute
				);
				$html .= sprintf(
					'<li class="%1$s" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a class="%2$s" itemprop="item" itemid="%3$s" href="%3$s"><span itemprop="name">%4$s</span><meta itemprop="position" content="%5$s" /></a></li>',
					esc_attr( $this->args->breadcrumb_item_class ),
					esc_attr( $this->args->breadcrumb_item_a_class ),
					$this->args->home_url,
					$this->args->home_name,
					$this->position,
				);

				foreach ( $this->get_breadcrumb() as $crumb ) {
					if ( $crumb['active'] === 'true' ) {
						$html .= sprintf(
							'<li class="%1$s" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><span itemprop="name">%2$s</span><meta itemprop="position" content="%3$s" /></li>',
							array_to_css_classes( [
								esc_attr( $this->args->breadcrumb_item_class ),
								esc_attr( $this->args->breadcrumb_item_active_class )
							] ),
							esc_html( $crumb['name'] ),
							$position,
						);
					} else {
						$html .= sprintf(
							'<li class="%1$s" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a class="%2$s" itemprop="item" itemid="%3$s" href="%3$s"><span itemprop="name">%4$s</span><meta itemprop="position" content="%5$s" /></a></li>',
							esc_attr( $this->args->breadcrumb_item_class ),
							esc_attr( $this->args->breadcrumb_item_a_class ),
							esc_url( $crumb['link'] ),
							esc_html( $crumb['name'] ),
							$position,
						);
					}

					$position ++;
				}

				$html .= sprintf(
					'</ol></%1$s>%2$s',
					$this->args->container,
					$this->args->after
				);
			}

			if ( $this->args->echo ) {
				echo $html;
			} else {
				return $html;
			}
		}

		/**
		 * Получает навигационную цепочку.
		 *
		 * Эта функция возвращает массив элементов навигационной цепочки, которые были
		 * сгенерированы и сохранены во время выполнения функции generate().
		 *
		 * @since 1.0.0
		 *
		 * @return array Массив элементов навигационной цепочки.
		 */
		public function get_breadcrumb(): array {
			return $this->crumbs;
		}

		/**
		 * Добавляет элемент в навигационную цепочку.
		 *
		 * Эта функция добавляет новый элемент в навигационную цепочку. Элемент может быть
		 * активным или неактивным, и он может иметь ссылку или нет.
		 *
		 * @since 1.0.0
		 *
		 * @param string $link Ссылка на элемент.
		 * @param int $active Флаг активности элемента (1 для активного, 0 для неактивного).
		 *
		 * @param string $name Имя элемента.
		 */
		public function add_crumb( string $name, string $link = '', int $active = 0 ) {
			$this->crumbs[] = apply_filters( 'isvek_theme_breadcrumb_crumb', [
				'name'   => wp_strip_all_tags( $name ),
				'link'   => $link,
				'active' => $active ? 'true' : 'false',
			] );
		}

		/**
		 * Генерирует навигационную цепочку.
		 *
		 * Эта функция генерирует навигационную цепочку на основе текущего состояния сайта.
		 * Она проверяет различные условия (например, является ли текущая страница домашней страницей,
		 * страницей ошибки 404 и т.д.) и добавляет соответствующие элементы в навигационную цепочку.
		 *
		 * @since 1.0.0
		 *
		 * @return array Пустой массив (не используется).
		 */
		protected function generate(): array {
			$conditionals = [
				'is_home',
				'is_404',
				'is_attachment',
				'is_single',
				'is_product_category',
				'is_product_tag',
				'is_shop',
				'is_page',
				'is_post_type_archive',
				'is_category',
				'is_tag',
				'is_author',
				'is_date',
				'is_tax',
				'is_search',
			];

			if ( ! is_front_page() ) {
				foreach ( $conditionals as $conditional ) {
					$method = 'add_crumbs_' . substr( $conditional, 3 );

					if ( function_exists( $conditional ) && call_user_func( $conditional ) && method_exists( $this, $method ) ) {
						call_user_func( [ $this, $method ] );
						break;
					}
				}

				$this->paged();
			}

			return [];
		}

		/**
		 * Добавляет главную страницу в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий главную страницу, в навигационную цепочку.
		 * Она использует заголовок одиночного поста в качестве имени элемента и URL домашней страницы в качестве ссылки.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_home() {
			$this->add_crumb( single_post_title( '', false, ), esc_url( get_home_url() ), false );
		}

		/**
		 * Добавляет страницу в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую страницу, в навигационную цепочку.
		 * Если текущая страница является дочерней, она также добавляет все родительские страницы в цепочку.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_page() {
			$id = get_the_ID();

			if ( wp_get_post_parent_id( $id ) ) {
				$post_ancestors = get_post_ancestors( $id );

				if ( is_array( $post_ancestors ) ) {
					foreach ( array_reverse( $post_ancestors ) as $post_ancestor ) {
						$this->add_crumb( get_the_title( $post_ancestor ), get_permalink( $post_ancestor ), false );
					}
				}
			}

			$this->add_crumb( get_the_title(), get_permalink(), true );
		}

		/**
		 * Добавляет категорию в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую категорию, в навигационную цепочку.
		 * Если текущая категория имеет родительские категории, она также добавляет их в цепочку.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_category() {
			$queried_object = get_queried_object();
			$category       = get_category( $queried_object );

			if ( 0 !== intval( $category->parent ) ) {
				$this->term_ancestors( $category->term_id, 'category' );
			}

			$this->add_crumb( single_cat_title( '', false ), get_category_link( $category->term_id ), true );
		}

		/**
		 * Добавляет вложение в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущее вложение, в навигационную цепочку.
		 * Она использует заголовок вложения в качестве имени элемента и URL вложения в качестве ссылки.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_attachment() {
			$this->add_crumb( get_the_title(), get_permalink(), true );
		}

		/**
		 * Добавляет хлебные крошки для одиночной записи.
		 *
		 * @since 1.0.0
		 */
		public function add_crumbs_single() {
			$get_post_type = get_post_type();
			$id            = get_the_ID();

			if ( function_exists( 'wc_get_product_terms' ) && 'product' === $get_post_type ) {
				$this->prepend_shop_page();

				$product_terms = wc_get_product_terms(
					$id,
					'product_cat',
					[
						'orderby' => 'parent',
						'order'   => 'DESC',
					]
				);

				if ( $product_terms ) {
					$main_term = apply_filters( 'isvek_theme_breadcrumb_main_term', $product_terms[0], $product_terms );
					$this->term_ancestors( $main_term->term_id, 'product_cat' );
					$this->add_crumb( $main_term->name, get_term_link( $main_term ), false );
				}
			} elseif ( 'post' === $get_post_type ) {
				if ( is_array( get_the_category() ) ) {
					foreach ( get_the_category() as $category ) {
						$this->add_crumb( get_cat_name( $category->term_id ), get_term_link( $category->term_id ),
							false );
					}
				}
			} else {
				$post_type_object = get_post_type_object( $get_post_type );

				if ( ! empty( $post_type_object ) ) {

					$this->add_crumb( $post_type_object->labels->singular_name,
						get_post_type_archive_link( $get_post_type ), false );

					$ancestors = get_ancestors( $id, $get_post_type );

					if ( is_array( $ancestors ) ) {
						foreach ( array_reverse( $ancestors ) as $ancestor ) {
							$this->add_crumb( get_the_title( $ancestor ), get_permalink( $ancestor ), false );
						}
					}
				}
			}

			$this->add_crumb( get_the_title(), '', true );
		}

		/**
		 * Добавляет одиночный пост или продукт в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущий пост или продукт, в навигационную цепочку.
		 * Если пост или продукт имеют родительские элементы (например, категории или родительские страницы),
		 * она также добавляет их в цепочку.
		 *
		 * @since 1.0.0
		 */
		protected function prepend_shop_page() {
			if ( function_exists( 'wc_get_permalink_structure' ) && function_exists( 'wc_get_page_id' ) ) {
				$permalinks   = wc_get_permalink_structure();
				$shop_page_id = wc_get_page_id( 'shop' );
				$shop_page    = get_post( $shop_page_id );

				// If permalinks contain the shop page in the URI prepend the breadcrumb with shop.
				if ( $shop_page_id && $shop_page && isset( $permalinks['product_base'] ) && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && intval( get_option( 'page_on_front' ) ) !== $shop_page_id ) {
					$this->add_crumb( get_the_title( $shop_page ), get_permalink( $shop_page ), false );
				}
			}
		}

		/**
		 * Добавляет магазин в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий магазин, в навигационную цепочку.
		 * Она использует заголовок страницы магазина или имя типа поста 'product' в качестве имени элемента
		 * и URL архива типа поста 'product' в качестве ссылки.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_shop() {
			$_name = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			if ( ! $_name ) {
				$product_post_type = get_post_type_object( 'product' );
				$_name             = $product_post_type->labels->name;
			}

			$this->add_crumb( $_name, get_post_type_archive_link( 'product' ), true );
		}

		/**
		 * Добавляет метку продукта в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую метку продукта, в навигационную цепочку.
		 * Она использует имя метки продукта и ссылку на метку продукта в качестве имени и ссылки элемента соответственно.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_product_tag() {
			$get_queried_object = get_queried_object();

			$this->add_crumb( sprintf( '%s: %s', __( 'Товары с меткой', 'isvek' ), $get_queried_object->name ), get_term_link( $get_queried_object, 'product_tag' ) );
		}

		/**
		 * Добавляет категорию продукта в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую категорию продукта, в навигационную цепочку.
		 * Если текущая категория продукта имеет родительские категории, она также добавляет их в цепочку.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_product_category() {
			$current_term = get_queried_object();

			$this->prepend_shop_page();
			$this->term_ancestors( $current_term->term_id, 'product_cat' );
			$this->add_crumb( $current_term->name, get_term_link( $current_term, 'product_cat' ), true );
		}

		/**
		 * Добавляет архив типа поста в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущий архив типа поста, в навигационную цепочку.
		 * Она использует заголовок архива типа поста и ссылку на архив типа поста в качестве имени и ссылки элемента соответственно.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_post_type_archive() {
			$post_type = get_post_type_object( get_post_type() );

			if ( $post_type ) {
				$this->add_crumb( post_type_archive_title( '', false ), get_post_type_archive_link( get_post_type() ), true );
			}
		}

		/**
		 * Добавляет таксономию в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую таксономию, в навигационную цепочку.
		 * Если текущая таксономия имеет родительские таксономии, она также добавляет их в цепочку.
		 *
		 * @since 1.0.0
		 */
		public function add_crumbs_tax() {
			$get_queried_object = get_queried_object();
			$taxonomy           = get_taxonomy( $get_queried_object->taxonomy );

			if ( mb_substr( $taxonomy->name, 0, 3 ) === 'pa_' ) {
				$this->add_crumb( $taxonomy->labels->name, home_url( $taxonomy->rewrite['slug'] ), false );
			} else {
				$this->add_crumb( $taxonomy->labels->name, '', false );
			}

			if ( 0 !== intval( $get_queried_object->parent ) ) {
				$this->term_ancestors( $get_queried_object->term_id, $get_queried_object->taxonomy );
			}

			$this->add_crumb( single_term_title( '', false ), get_term_link( $get_queried_object->term_id, $get_queried_object->taxonomy ), true );
		}

		/**
		 * Добавляет дату в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую дату, в навигационную цепочку.
		 * Если текущая страница представляет определенный год, месяц или день, она добавляет их в цепочку.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_date() {
			if ( is_year() || is_month() || is_day() ) {
				$this->add_crumb( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ), false );
			}

			if ( is_month() || is_day() ) {
				$this->add_crumb( get_the_time( 'F' ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), false );
			}

			if ( is_day() ) {
				$this->add_crumb( get_the_time( 'd' ), '', true );
			}
		}

		/**
		 * Добавляет тег в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущий тег, в навигационную цепочку.
		 * Она использует имя тега и ссылку на тег в качестве имени и ссылки элемента соответственно.
		 *
		 * @since 1.0.0
		 */
		public function add_crumbs_tag() {
			$queried_object = get_queried_object();

			$this->prepend_shop_page();
			$this->add_crumb( sprintf( '%s: %s', __( 'Публикации помечены как', 'isvek' ), single_tag_title( '', false ) ), get_tag_link( $queried_object->term_id ), true );
		}

		/**
		 * Добавляет автора в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущего автора, в навигационную цепочку.
		 * Она использует отображаемое имя автора в качестве имени элемента.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_author() {
			$this->add_crumb( 'Автор: ' . get_the_author_meta( 'display_name' ), '', true );
		}

		/**
		 * Добавляет номер страницы в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущую страницу (если это страница пагинации), в навигационную цепочку.
		 * Она использует номер страницы и форматирует его как "Страница X", где X - это номер страницы.
		 *
		 * @since 1.0.0
		 */
		protected function paged() {
			if ( get_query_var( 'paged' ) ) {
				$this->add_crumb( sprintf( '%s %d', __( 'Страница', 'isvek' ), get_query_var( 'paged' ) ), '', true );
			}

			if ( get_query_var( 'product-page' ) ) {
				$this->add_crumb( sprintf( '%s %d', __( 'Страница', 'isvek' ), get_query_var( 'product-page' ) ), '',
					true );
			}
		}

		/**
		 * Добавляет ошибку 404 в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий ошибку 404, в навигационную цепочку.
		 * Она использует сообщение об ошибке 404 в качестве имени элемента.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_404() {
			$this->add_crumb( __( 'Страница не найдена - ошибка 404', 'isvek' ), '', true );
		}

		/**
		 * Добавляет поиск в навигационную цепочку.
		 *
		 * Эта функция добавляет элемент, представляющий текущий поиск, в навигационную цепочку.
		 * Она использует поисковый запрос в качестве имени элемента.
		 *
		 * @since 1.0.0
		 */
		protected function add_crumbs_search() {
			$this->add_crumb( __( 'Поиск: ', 'isvek' ) . get_search_query(), '', true );
		}

		/**
		 * Возвращает предков термина и добавляет их в хлебную крошку.
		 *
		 * @since 1.0.0
		 *
		 * @param int $term_id ID термина, для которого находятся предки.
		 * @param string $taxonomy Таксономия термина.
		 *
		 * @return void
		 */
		protected function term_ancestors( int $term_id, string $taxonomy ) {
			$ancestors = get_ancestors( $term_id, $taxonomy );
			$ancestors = array_reverse( $ancestors );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $taxonomy );

				if ( ! is_wp_error( $ancestor ) && $ancestor ) {
					$this->add_crumb( $ancestor->name, get_term_link( $ancestor ), false );
				}
			}
		}
	}
}
