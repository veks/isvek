<?php
/**
 * Layout header
 *
 * @since 1.0.0
 * @package Isvek\Theme
 */

?>

<nav class="navbar <?php echo isvek_theme_get_option( 'header.navbar.expand' ); ?> bg-white mb-4">

	<div class="<?php echo isvek_theme_get_option( 'content.container' ); ?>">

		<?php if ( isvek_theme_get_option( 'header.navbar.display-brand' ) ) : ?>

			<?php if ( has_custom_logo() ) : ?>

				<a href="<?php echo esc_url( home_url() ); ?>" class="navbar-brand navbar-brand-item"><?php isvek_theme_template_custom_logo() ?></a>

			<?php else: ?>

				<a href="<?php echo esc_url( home_url() ); ?>" class="navbar-brand"><?php bloginfo(); ?></a>

			<?php endif; ?>

		<?php endif; ?>

		<button class="navbar-toggler border-0<?php echo ! isvek_theme_get_option( 'header.navbar.display-brand' ) ? ' w-100' : ''; ?>" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-label="<?php _e( 'Переключить меню', 'isvek' ); ?>">

			<span class="navbar-toggler-icon"></span>

		</button>

		<div id="offcanvas-navbar" class="offcanvas <?php echo isvek_theme_get_option( 'header.navbar.offcanvas' ); ?>" tabindex="-1">

			<div class="offcanvas-header shadow-sm">

				<h5 class="offcanvas-title fw-light fs-4"><?php echo wp_get_nav_menu_name( 'isvek-theme-header-nav-menu' ); ?></h5>

				<button class="btn-close btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="<?php _e( 'Закрыть меню', 'isvek' ); ?>"></button>

			</div>

			<div class="offcanvas-body <?php echo isvek_theme_get_option( 'header.navbar.alignment' ); ?>">

				<?php
				wp_nav_menu(
					[
						'theme_location' => 'isvek-theme-header-nav-menu',
						'container'      => false,
						'menu_class'     => 'navbar-nav justify-content-end mt-1',
						'depth'          => 11,
						'fallback_cb'    => '\\Isvek\\Theme\\Walker\\NavMenuV1::fallback',
						'walker'         => new Isvek\Theme\Walker\NavMenuV1(
							[
								'dropdown_menu_class'   => 'dropdown-menu dropdown-animation',
								'dropdown_toggle_data' => [
									'data-bs-toggle'     => 'dropdown',
									'data-bs-auto-close' => 'outside',
									'aria-expanded'      => 'false',
									'data-bs-trigger'    => 'hover',
								]
							]
						),
					]
				);
				?>

			</div>

		</div>

	</div>

</nav>
