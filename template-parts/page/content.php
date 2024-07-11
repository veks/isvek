<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */
?>

<article id="page page-<?php the_ID(); ?>" <?php post_class( 'page' ); ?>>

	<div id="content" class="m-0 p-0"></div>

	<h1 class="page-title fw-light fs-2 mb-3"><?php the_title(); ?></h1>

	<div class="card">

		<div class="card-body">

			<?php if ( has_post_thumbnail() ) : ?>

				<figure>

					<?php the_post_thumbnail(
						'full',
						[
							'class'    => 'rounded float-start img-fluid me-3 mb-1',
						]
					);
					?>

				</figure>

			<?php endif; ?>

			<div class="page-content">

				<?php the_content(); ?>

			</div>

		</div>

	</div>

	<?php wp_link_pages(); ?>

</article>
