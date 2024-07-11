<?php
/**
 * Шаблон для отображения страниц результатов поиска.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

get_header();

if ( isvek_theme_get_option( 'content.search' ) ) :

	$query = new WP_Query(
		[
			'posts_per_page' => get_option( 'posts_per_page' ),
			's'              => sanitize_text_field( wp_unslash( $_GET['s'] ) ),
			'post_type'      => 'any',
			'orderby'        => 'post_date',
			'post_status'    => [ 'publish' ],
		]
	);

	add_filter( 'excerpt_length', function () {
		return 50;
	} );

	add_filter( 'excerpt_more', function () {
		return '...';
	} );

	?>

	<div id="content" class="m-0 p-0"></div>

	<h1 class="post-title fw-light fs-2"><?php _e( 'Поиск', 'isvek' ); ?></h1>
	<div class="bg-white p-4 mb-4 rounded-2">

		<?php get_search_form(); ?>

		<div class="text-secondary mt-1">

			<?php _e( 'По вашему запросу', 'isvek' ); ?>
			<?php echo esc_html( isvek_theme_num_decline( $query->found_posts, __( 'найден,найдена,найдено', 'isvek' ) ) ); ?>
			:
			<?php echo esc_html( isvek_theme_num_decline( $query->found_posts, __( 'результат,результата,результатов', 'isvek' ), true ) ); ?>
			.

		</div>
	</div>

	<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : ?>

		<?php the_post(); ?>

		<?php if ( 'page' === get_post_type() ) : ?>

			<?php get_template_part( 'template-parts/page/content-excerpt-search.php' ); ?>

		<?php elseif ( 'post' === get_post_type() ) : ?>

			<?php get_template_part( 'template-parts/single/excerpt' ); ?>

		<?php elseif ( 'product' === get_post_type() ) : ?>

			<?php get_template_part( 'template-parts/page/content-excerpt-search.php' ); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/none' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php

	/**
	 * Hook: isvek_theme_pagination.
	 *
	 * @hooked isvek_theme_template_pagination - 10
	 */
	do_action( 'isvek_theme_pagination' );
	?>

<?php else : ?>

	<div class="text-center">

		<h3 class="fw-light fs-3 mb-3">

			<?php _e( 'По запросу', 'isvek' ); ?>

			<u><?php echo get_search_query(); ?></u>

			<?php _e( 'ничего не найдено', 'isvek' ); ?>.

		</h3>

	</div>

	<div class="mt-2 text-dark">

		<ul>
			<li><?php _e( 'Убедитесь, что все слова написаны без ошибок', 'isvek' ); ?>.</li>
			<li><?php _e( 'Попробуйте использовать другие ключевые слова', 'isvek' ); ?>.</li>
		</ul>

	</div>

<?php endif; ?>

<?php else : ?>

	<?php get_template_part( '404' ); ?>

<?php endif; ?>

<?php get_footer();
