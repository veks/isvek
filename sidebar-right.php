<?php
/**
 * Боковая панель, содержащая основную область виджета.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-files
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

?>

<?php if ( is_active_sidebar( 'isvek-sidebar-right' ) && ! is_404() ) : ?>

	<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 order-sm-last order-md-last order-lg-last order-xl-last order-xxl-last mt-4 mt-lg-0 ">

		<aside class="isvek-sidebar-right" role="complementary">

			<?php dynamic_sidebar( 'isvek-sidebar-right' ); ?>

		</aside>

	</div>

<?php endif; ?>