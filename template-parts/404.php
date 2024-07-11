<article id="page page-404" <?php post_class( 'page' ); ?>>

	<div class="d-flex align-items-center justify-content-center" style="height: 400px;">

		<div class="text-center">

			<header>

				<h1 class="display-2 fw-light"><?php _e( 'Ошибка 404', 'isvek' ); ?></h1>

			</header>

			<div>

				<p class="fs-3">
					<span class="text-danger">

						<?php _e( 'Упс!', 'isvek' ); ?>

					</span>

					<?php _e( 'Страница не найдена.', 'isvek' ); ?>

				</p>

				<p class="lead">
					<?php _e( 'Страница, которую вы ищете, не существует.', 'isvek' ); ?>
				</p>

				<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-primary" title="<?php _e( 'Вернуться на главную страницу', 'isvek' ); ?>">
					<?php _e( 'Вернуться на главную страницу', 'isvek' ); ?>
				</a>
			</div>
		</div>
	</div>
</article>
