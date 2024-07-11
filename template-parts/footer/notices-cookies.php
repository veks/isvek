<div aria-live="polite" aria-atomic="true" class="bg-dark position-relative" style="z-index: 1029;">

	<div class="toast-container position-fixed bottom-0 end-0 p-3 animate__animated animate__slideInUp">

		<div id="toast-cookie" class="toast" role="alert" aria-live="assertive" aria-atomic="true">

			<div class="toast-header">

				<strong class="me-auto"><?php _e( 'Веб-сайт использует файлы cookie', 'isvek' ); ?></strong>
				<i class="fa-solid fa-cookie-bite text-warning"></i>

			</div>

			<div class="toast-body" style="text-align: justify;">

				<?php _e( 'Этот сайт использует «cookies». Также сайт использует интернет-сервис для сбора технических данных касательно посетителей с целью получения статистической информации.', 'isvek' ); ?>
				<?php _e( 'Ознакомьтесь с нашей', 'isvek' ); ?>

				<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">
					<?php _e( 'Политикой конфиденциальности', 'isvek' ); ?>
				</a>.

				<div class="text-center mt-2">

					<button class="cookie-agree btn btn-outline-success btn-sm" aria-label="<?php _e( 'Согласен', 'isvek' ); ?>">
						<i class="fa-solid fa-check"></i> <?php _e( 'Согласен', 'isvek' ); ?>
					</button>

				</div>

			</div>

		</div>

	</div>

</div>
