<?php
$bootstrap = new Isvek\Theme\Bootstrap();
?>

<footer class="footer bg-white border-top mt-4">

	<div class="container">

		<div class="py-4">

			<div class="row align-items-center">

				<div class="col-md-8">

					<span class="text-muted">
						Copyright 2022 © HTML Template. All rights reserved. Powered by
						<a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_attr( $bootstrap->get_name() ); ?></a>.
					</span>
				</div>

			</div>

		</div>

	</div>

</footer>
