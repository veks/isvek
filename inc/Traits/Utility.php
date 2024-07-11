<?php
/**
 * Utility class.
 *
 * @class   Utility
 * @version 1.0.0
 * @package Isvek\Theme\Traits
 */

namespace Isvek\Theme\Traits;

defined( 'ABSPATH' ) || exit;

if ( ! trait_exists( 'Isvek\Theme\Traits\Utility' ) ) {

	/**
	 * Utility class.
	 */
	trait Utility {

		/**
		 * Получить имя темы.
		 *
		 * Эта функция возвращает строку, представляющую имя темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает имя темы.
		 */
		public function get_name(): string {
			return 'Isvek';
		}

		/**
		 * Получить файл темы.
		 *
		 * Эта функция возвращает базовое имя файла темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает базовое имя файла темы.
		 */
		public function get_file(): string {
			return basename( ISVEK_THEME_FILE );
		}

		/**
		 * Получить путь к директории темы.
		 *
		 * Эта функция возвращает путь к директории темы с добавлением опционального пути.
		 *
		 * @since 1.0.0
		 *
		 * @param string $path Опциональный путь, который нужно добавить к пути директории темы.
		 *
		 * @return string Возвращает путь к директории темы.
		 */
		public function get_dir_path( string $path = '' ): string {
			return trailingslashit( get_template_directory() . $path );
		}

		/**
		 * Получает путь к каталогу языковых файлов темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Путь к каталогу языковых файлов темы.
		 */
		public function get_dir_path_languages(): string {
			return $this->get_dir_path( '/languages' );
		}

		/**
		 * Получает URL-адрес каталога темы.
		 *
		 * @since 1.0.0
		 * @return string URL-адрес каталога темы.
		 */
		public function get_dir_url( $path = '' ): string {
			return trailingslashit( esc_url( get_template_directory_uri() . $path ) );
		}

		/**
		 * Получает URL-адрес каталога темы для CSS-файлов.
		 *
		 * @since 1.0.0
		 *
		 * @param string $path Относительный путь к CSS-файлу внутри каталога темы. По умолчанию пустая строка.
		 *
		 * @return string URL-адрес каталога темы для CSS-файлов.
		 */
		public function dir_url_css( string $path = '' ): string {
			return $this->get_dir_url( '/assets/css/' . $path );
		}

		/**
		 * Получает URL-адрес каталога темы для JavaScript-файлов.
		 *
		 * @since 1.0.0
		 *
		 * @param string $path Относительный путь к JavaScript-файлу внутри каталога темы. По умолчанию пустая строка.
		 *
		 * @return string URL-адрес каталога темы для JavaScript-файлов.
		 */
		public function get_dir_url_js( string $path = '' ): string {
			return $this->get_dir_url( '/assets/js/' . $path );
		}

		/**
		 * Получить слуг темы.
		 *
		 * Эта функция возвращает строку, представляющую слаг темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает слуг темы.
		 */
		public function get_slug(): string {
			return apply_filters( 'isvek_theme_slug', 'isvek-theme' );
		}

		/**
		 * Получить настройки слага темы.
		 *
		 * Эта функция возвращает строку, представляющую настройки слага темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает настройки слуг темы.
		 */
		public function get_slug_settings(): string {
			return apply_filters( 'isvek_theme_slug_settings', 'isvek-theme-settings' );
		}

		/**
		 * Получить префикс темы.
		 *
		 * Эта функция возвращает строку, представляющую префикс темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает префикс темы.
		 */
		public function get_prefix(): string {
			return 'it';
		}

		/**
		 * Получить имя опции темы.
		 *
		 * Эта функция возвращает строку, представляющую имя опции темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает имя опции темы.
		 */
		public function get_option_name(): string {
			return ISVEK_THEME_OPTION_NAME;
		}

		/**
		 * Получить версию темы.
		 *
		 * Эта функция возвращает строку, представляющую версию темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает версию темы.
		 */
		public function get_version(): string {
			return ISVEK_THEME_VERSION;
		}

		/**
		 * Получить версию базы данных темы.
		 *
		 * Эта функция возвращает строку, представляющую версию базы данных темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает версию базы данных темы.
		 */
		public function get_db_version(): string {
			return ISVEK_THEME_DB_VERSION;
		}

		/**
		 * Получить возможности темы.
		 *
		 * Эта функция возвращает строку, представляющую возможности темы. Она также использует фильтр WordPress 'apply_filters',
		 * что позволяет другим разработчикам или плагинам изменять это значение.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает возможности темы.
		 */
		public function get_capability(): string {
			return apply_filters( 'isvek_theme_capability', 'administrator' );
		}

		/**
		 * Получить группу опций темы.
		 *
		 * Эта функция возвращает строку, представляющую группу опций темы.
		 *
		 * @since 1.0.0
		 *
		 * @return string Возвращает группу опций темы.
		 */
		public function get_option_group(): string {
			return apply_filters( 'isvek_theme_option_group', 'isvek-theme-option-group' );
		}
	}
}
