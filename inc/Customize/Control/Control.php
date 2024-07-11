<?php
/**
 * Control class.
 *
 * @class   Control
 * @version 1.0.0
 * @package Isvek\Theme\Customize\Control
 */

namespace Isvek\Theme\Customize\Control;

use Isvek\Theme\Traits\Utility;
use WP_Customize_Control;

if ( ! class_exists( 'Isvek\Theme\Customize\Control\Control' ) ) {

	/**
	 * Control class.
	 */
	class Control extends WP_Customize_Control {
		use Utility;
	}
}
