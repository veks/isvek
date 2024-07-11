<?php
/**
 * Template part for displaying page content in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

$tags = get_the_tags();
?>

<article id="post post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<div id="content" class="m-0 p-0"></div>

	<h1 class="post-title fw-light fs-2"><?php the_title(); ?></h1>

	<div class="d-flex flex-wrap align-items-center text-dark mb-2">

		<div class="me-2"><?php _e( 'Опубликовано', 'isvek' ); ?>:</div>

		<time class="me-2">
			<i class="fa-regular fa-calendar me-1"></i>
			<?php the_time( 'd F Y' ); ?>
		</time>

		<div class="me-2">
			<i class="fa-regular fa-clock me-1"></i><?php the_time( 'H:i' ) ?>
		</div>

		<div class="me-2">
			<i class="fa-regular fa-user me-1"></i>
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="Автор: <?php the_author(); ?>" rel="author">
				<span><?php the_author(); ?></span>
			</a>
		</div>

		<div class="me-3 category tag">
			<i class="fa-solid fa-tags me-1"></i><?php the_category( ', ', 'multiple' ); ?>
		</div>

	</div>

	<?php if ( $tags ) : ?>

		<div class="d-block mt-3 tag mb-3">

			<?php foreach ( $tags as $tag ) : ?>

				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="btn btn-primary-soft btn-sm mb-1" title="<?php echo esc_attr( $tag->name ); ?>" rel="tag">
					<?php echo $tag->name; ?>
				</a>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>

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

			<div class="post-content">

				<?php the_content(); ?>

			</div>

		</div>

	</div>

</article>
