<?php
/**
 * Template part for displaying page content in search.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

$tags = wp_get_post_tags( get_the_ID() );

?>
<article id="page page-<?php the_ID(); ?>" <?php post_class( 'page page-excerpt' ); ?>>
	<div class="card position-relative mb-4">
		<div class="card-body">
			<div class="row gx-3">
				<div class="col-12 mb-3">
					<div class="border-bottom mb-1 pb-1">
						<h2 class="post-title page-title fw-light fs-2"><?php the_title(); ?></h2>
					</div>
				</div>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="col-auto">
						<figure>
							<?php the_post_thumbnail(
								'medium',
								[
									'class'    => 'rounded float-start img-fluid me-3 mb-1',
									'itemprop' => 'image url',
								] );
							?>
						</figure>
					</div>
				<?php endif; ?>
				<div class="col">
					<div class="page-content">
						<?php the_excerpt(); ?>
					</div>
					<div class="d-block">
						<?php if ( get_edit_post_link() ) : ?>
							<?php edit_post_link( '<i class="fas fa-pencil-alt"></i>', '', '', '', 'btn btn-danger btn-sm stretched-no-link' ); ?>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm stretched-link" title="<?php _e( 'Подробнее', 'isvek' ); ?>" rel="index">
							<?php _e( 'Подробнее', 'isvek' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $tags ) : ?>
			<div class="card-footer">
				<?php foreach ( $tags as $tag ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="btn btn-primary-soft btn-sm mb-1 stretched-no-link" title="<?php echo esc_attr( $tag->name ); ?>" rel="tag"><?php echo $tag->name; ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
