<?php
/**
 * Bootstrap class.
 *
 * @class   Bootstrap
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

use Isvek\Theme\Traits\Utility;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Bootstrap' ) ) {

	/**
	 * Bootstrap class.
	 */
	class Bootstrap {
		use Utility;
	}
}

