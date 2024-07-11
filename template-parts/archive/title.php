<?php
$classes = apply_filters( 'isvek_theme_classes_archive_title', 'page-title fw-light fs-2 mb-3' );
?>

	<h1 class="<?php echo esc_attr( $classes ); ?>">

		<?php the_archive_title(); ?>

	</h1>

<?php if ( get_the_archive_description() ) : ?>

	<div class="text-muted">

		<?php the_archive_description(); ?>

	</div>

<?php endif;
