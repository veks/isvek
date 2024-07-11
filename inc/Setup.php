<?php
/**
 * Setup class.
 *
 * Начальная настройка для этой тем.
 *
 * @class   Setup
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Setup' ) ) {

	/**
	 * Setup class.
	 */
	class Setup extends Bootstrap {

		/**
		 * Конструктор класса.
		 *
		 * Этот конструктор инициализирует свойства класса.
		 * Он также добавляет несколько действий и фильтров с помощью функций `add_action()` и `add_filter()`.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'admin_init', [ $this, 'has_options' ] );
			add_action( 'after_setup_theme', [ $this, 'setup' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'add_enqueue_scripts' ], 50 );
			add_action( 'get_footer', [ $this, 'add_footer_styles' ], 98 );
			add_action( 'deleted_theme', [ $this, 'deleted_theme' ], 10, 1 );

			add_filter( 'excerpt_more', [ $this, 'add_excerpt_more' ] );
		}

		/**
		 * Настраивает тему.
		 *
		 * Эта функция настраивает тему, регистрируя меню навигации, добавляя поддержку различных функций темы
		 * и устанавливая опции темы. Она не принимает никаких аргументов и не возвращает никакого значения.
		 *
		 * Функция регистрирует меню навигации с именем 'isvek-header-nav-menu' и описанием 'Панель навигации'.
		 *
		 * Функция также добавляет поддержку следующих функций темы: 'automatic-feed-links', 'title-tag',
		 * 'post-thumbnails', 'html5', 'custom-logo', 'customize-selective-refresh-widgets', 'wp-block-styles',
		 * 'editor-styles', 'responsive-embeds', 'widgets-block-editor' и 'align-wide'. Она также добавляет
		 * поддержку палитры цветов редактора с определенными цветами.
		 *
		 * Функция добавляет стиль редактора для файла 'bootstrap.min.css' и загружает текстовый домен темы
		 * с помощью функции `load_theme_textdomain()`.
		 *
		 * В конце функция вызывает метод `set_options()` для установки опций темы.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function setup() {
			register_nav_menus(
				[
					'isvek-theme-header-nav-menu' => __( 'Панель навигации', 'isvek' ),
				]
			);

			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support(
				'html5',
				[
					'comment-list',
					'comment-form',
					'search-form',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);

			add_theme_support(
				'custom-logo',
				[
					'width'                => 240,
					'height'               => 40,
					'flex-height'          => true,
					'flex-width'           => true,
					'header-text'          => [ 'site-title', 'site-description' ],
					'unlink-homepage-logo' => true,
				]
			);

			add_theme_support( 'customize-selective-refresh-widgets' );
			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'editor-styles' );
			add_theme_support( 'responsive-embeds' );
			add_theme_support( 'widgets-block-editor' );
			add_theme_support( 'align-wide' );
			add_theme_support( 'editor-color-palette', [
				[
					'name'  => 'primary',
					'slug'  => 'primary',
					'color' => '#2163e',
				],
				[
					'name'  => 'secondary',
					'slug'  => 'secondary',
					'color' => '#f3f5f9',
				],
				[
					'name'  => 'info',
					'slug'  => 'info',
					'color' => '#69b3fe',
				],
				[
					'name'  => 'success',
					'slug'  => 'success',
					'color' => '#42d697',
				],
				[
					'name'  => 'warning',
					'slug'  => 'warning',
					'color' => '#fea569',
				],
				[
					'name'  => 'danger',
					'slug'  => 'danger',
					'color' => '#f34770',
				],
				[
					'name'  => 'light',
					'slug'  => 'light',
					'color' => '#fff',
				],
				[
					'name'  => 'dark',
					'slug'  => 'dark',
					'color' => '#373f50',
				],
			] );

			add_editor_style( [ $this->dir_url_css() . 'bootstrap.min.css' ] );

			load_theme_textdomain( 'isvek', $this->get_dir_path_languages() );

			$this->set_options();
		}

		/**
		 * Функция для экшен-хука `deleted_theme`.
		 *
		 * @return void
		 */
		public function deleted_theme( $stylesheet ) {
			if ( strtolower( $this->get_name() ) === $stylesheet ) {
				delete_option( $this->get_option_name() );
			}
		}

		/**
		 * Регистрирует и ставит в очередь скрипты и стили.
		 *
		 * Эта функция регистрирует и ставит в очередь скрипты и стили, которые необходимы для работы темы.
		 * Она проверяет, определена ли константа `SCRIPT_DEBUG` и включен ли режим отладки, а также
		 * проверяет значение опции темы `content.debug`. Если хотя бы одно из этих условий истинно,
		 * то используется несжатая версия скриптов и стилей (без суффикса `.min`).
		 *
		 * Если текущая страница является отдельным постом, комментарии к которому открыты, и включена опция
		 * `thread_comments`, то функция ставит в очередь скрипт `comment-reply`.
		 *
		 * Функция также ставит в очередь несколько стилей: `isvek-roboto`, `isvek-bootstrap`, `isvek-font-awesome`
		 * и `isvek-animate`. Она также ставит в очередь скрипт `isvek-bootstrap-bundle` и регистрирует скрипт
		 * `isvek-theme`.
		 *
		 * Если включена опция темы `content.search`, то функция локализует скрипт `isvek-theme`, добавляя
		 * данные для поиска. Если включена опция темы `content.debug`, то функция добавляет встроенный скрипт,
		 * который выводит в консоль значения опций темы при загрузке страницы.
		 *
		 * В конце функция ставит в очередь скрипт `isvek-theme`.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function add_enqueue_scripts() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || isvek_theme_get_option( 'content.debug' ) ? '' : '.min';

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_enqueue_style(
				$this->get_slug() . '-roboto',
				$this->dir_url_css() . 'roboto' . $suffix . '.css',
				false,
				$this->get_version()
			);

			wp_enqueue_style(
				$this->get_slug() . '-wp',
				$this->dir_url_css() . 'wp' . $suffix . '.css',
				false,
				$this->get_version()
			);

			wp_enqueue_style(
				$this->get_slug() . '-bootstrap',
				$this->dir_url_css() . 'bootstrap' . $suffix . '.css',
				false,
				'5.3.3'
			);

			wp_enqueue_style(
				$this->get_slug() . '-font-awesome',
				$this->dir_url_css() . 'all' . $suffix . '.css',
				false,
				'6.4.2'
			);

			wp_enqueue_style(
				$this->get_slug() . '-animate',
				$this->dir_url_css() . 'animate' . $suffix . '.css',
				false,
				'4.1.1'
			);

			wp_enqueue_script(
				$this->get_slug() . '-bootstrap-bundle',
				$this->get_dir_url_js() . 'bootstrap.bundle' . $suffix . '.js',
				true,
				'5.3.3',
				true
			);

			wp_register_script(
				$this->get_slug(),
				$this->get_dir_url_js() . 'theme' . $suffix . '.js',
				true,
				$this->get_version(),
				true
			);

			if ( isvek_theme_get_option( 'content.search' ) ) {
				wp_localize_script(
					$this->get_slug(),
					'isvek_theme_search',
					[
						'url_ajax' => admin_url( 'admin-ajax.php' ),
						'security' => wp_create_nonce( 'isvek_theme_search_nonce' ),
						'action'   => 'isvek_theme_search',
					]
				);
			}

			if ( isvek_theme_get_option( 'content.debug' ) ) {
				wp_add_inline_script(
					$this->get_slug(),
					'document.addEventListener("DOMContentLoaded", () => console.log(' . wp_json_encode( array_reverse( get_option( $this->get_option_name() ) ) ) . '))'
				);
			}

			wp_enqueue_script( $this->get_slug() );
		}

		/**
		 * Добавляет стили в подвал сайта.
		 *
		 * Эта функция добавляет стили в подвал сайта. Она не принимает никаких аргументов и не возвращает никакого значения.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function add_footer_styles() {
			//
		}

		/**
		 * Добавляет атрибут defer к тегу script.
		 *
		 * Эта функция принимает два аргумента: `$tag` - тег script, к которому нужно добавить атрибут defer,
		 * и `$handle` - имя обработчика. Если в имени обработчика содержится подстрока 'isvek'
		 * (регистр не учитывается), то функция возвращает измененный тег с добавленным атрибутом defer.
		 * В противном случае функция возвращает исходный тег без изменений.
		 *
		 * @since 1.0.0
		 *
		 * @param string $handle Имя обработчика.
		 *
		 * @param string $tag Тег script, к которому нужно добавить атрибут defer.
		 *
		 * @return string Измененный тег с добавленным атрибутом defer или исходный тег без изменений.
		 */
		public function add_script_attribute( string $tag, string $handle ): string {
			if ( stripos( strtolower( $handle ), 'isvek' ) !== false ) {
				return str_replace( ' src', ' defer src', $tag );
			}

			return $tag;
		}

		/**
		 * Добавляет атрибут style к тегу.
		 *
		 * Эта функция принимает два аргумента: `$tag` - тег, к которому нужно добавить атрибут style,
		 * и `$handle` - имя обработчика. Если в имени обработчика содержится подстрока 'isvek'
		 * (регистр не учитывается), то функция возвращает измененный тег с добавленным атрибутом style.
		 * В противном случае функция возвращает исходный тег без изменений.
		 *
		 * @since 1.0.0
		 *
		 * @param string $handle Имя обработчика.
		 *
		 * @param string $tag Тег, к которому нужно добавить атрибут style.
		 *
		 * @return string Измененный тег с добавленным атрибутом style или исходный тег без изменений.
		 */
		public function add_style_attribute( string $tag, string $handle ): string {
			if ( stripos( strtolower( $handle ), 'isvek' ) !== false ) {
				return sprintf( '%1$s<noscript>%3$s%2$s</noscript>%3$s', preg_replace( "/rel='[a-zA-Z\d]+'/i", 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"', $tag ), $tag, PHP_EOL );
			}

			return $tag;
		}

		/**
		 * Добавляет символы многоточия в конец цитаты.
		 *
		 * Эта функция возвращает строку с символами многоточия ('...'), которая может быть использована
		 * для добавления в конец цитаты, чтобы указать, что текст продолжается.
		 *
		 * @since 1.0.0
		 *
		 * @return string Строка с символами многоточия.
		 */
		public function add_excerpt_more(): string {
			return '...';
		}

		/**
		 * Устанавливает опции темы.
		 *
		 * Эта функция устанавливает опции темы. Если функция выполняется в административной панели,
		 * то она проверяет, имеются ли опции темы, вызывая функцию `isvek_theme_get_option()`. Если опции темы
		 * отсутствуют (возвращаемое значение равно `false`), то функция вызывает функцию `add_option()`
		 * с именем опции `$this->option_name` и значением по умолчанию, возвращаемым методом `get_default_option()`.
		 * Если версия базы данных (`$this->db_version`) больше, чем версия, хранящаяся в опциях темы
		 * (`isvek_theme_get_option( 'version' )`), то функция вызывает функцию `update_option()` с именем опции
		 * `$this->option_name` и значением по умолчанию, возвращаемым методом `get_default_option()`.
		 * Если функция не выполняется в административной панели, то никакие действия не выполняются.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function set_options() {
			if ( is_admin() ) {
				if ( isvek_theme_get_option() === false ) {
					add_option( $this->get_option_name(), $this->get_default_option() );
				}

				if ( version_compare( $this->get_db_version(), isvek_theme_get_option( 'db_version' ), '>' ) ) {
					update_option( $this->get_option_name(), $this->get_default_option() );
				}
			}
		}

		/**
		 * Проверяет, имеются ли опции темы.
		 *
		 * Эта функция проверяет, имеются ли опции темы. Если функция выполняется в административной панели,
		 * то она проверяет, имеются ли опции темы, вызывая функцию `isvek_theme_get_option()`. Если опции темы
		 * отсутствуют или пусты (возвращаемое значение равно `false` или пусто), то функция вызывает метод
		 * `set_options()` для установки опций темы. Если функция не выполняется в административной панели,
		 * то никакие действия не выполняются.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function has_options() {
			if ( is_admin() ) {
				if ( false === isvek_theme_get_option() || empty( isvek_theme_get_option() ) ) {
					$this->set_options();
				}
			}
		}

		/**
		 * Опции по умолчанию.
		 *
		 * @since 1.0.0
		 *
		 * @return array
		 */
		public function get_default_option(): array {
			return [
				'version'    => $this->get_version(),
				'db_version' => $this->get_db_version(),
				'header'     => [
					'navbar' => [
						'display-brand' => 1,
						'expand'        => 'navbar-expand-lg',
						'offcanvas'     => 'offcanvas-start',
						'alignment'     => 'justify-content-start',
					]
				],
				'content'    => [
					'search'    => 1,
					'debug'     => 0,
					'container' => 'container',
				],
				'footer'     => []
			];
		}
	}
}
