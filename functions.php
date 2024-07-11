<?php
/**
 * Функции и определения.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Константы.
 */
if ( ! defined( 'ISVEK_THEME_FILE' ) ) {
	define( 'ISVEK_THEME_FILE', __FILE__ );
}

/**
 * Isvek Theme работает только в версии PHP 7.4 или новее.
 */
if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
	add_action( 'admin_notices', function () {
		printf(
			'<div class="notice notice-error is-dismissible"><p>Для работы темы <strong>Isvek</strong> требуется минимум версия <strong>%1$s</strong> PHP. У Вас <strong>%2$s</strong> PHP версия.</p></div>',
			'7.4',
			PHP_VERSION
		);
	} );
} else {
	/**
	 * Константы.
	 */
	define( 'ISVEK_THEME_VERSION', '1.0.7' );
	define( 'ISVEK_THEME_OPTION_NAME', 'isvek-theme' );
	define( 'ISVEK_THEME_DB_VERSION', '107' );
	define( 'ISVEK_THEME_OLD_VERSION', '106' );

	if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
		require __DIR__ . '/vendor/autoload.php';
	}

	if ( class_exists( Isvek\Theme\Loader::class ) ) {
		$loader = new Isvek\Theme\Loader();
		$loader->set( [
			Isvek\Theme\Setup::class,
			Isvek\Theme\Search::class,
			Isvek\Theme\Customize\Customize::class,
			Isvek\Theme\Widget::class,
		] )->init();
	}
}
