<?php
/**
 * Шаблон для отображения комментариев.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * Это шаблон, который отображает область страницы, содержащую как текущие комментарии и форму комментариев.
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

if ( post_password_required() ) {
	return;
}

$get_comments_number = get_comments_number();
$num                 = isvek_theme_num_decline(
	$get_comments_number, [
		__( 'Комментарий', 'isvek' ),
		__( 'Комментария', 'isvek' ),
		__( 'Комментариев', 'isvek' )
	]
);
$comments            = get_comments( [ 'post_id' => get_the_ID(), 'status' => 'approve' ] );
$commenter           = wp_get_current_commenter();
$req                 = get_option( 'require_name_email' );
$consent             = empty( $commenter['comment_author_email'] ) ? '' : ' checked';
$required_indicator  = ' ' . wp_required_field_indicator();
$required_text       = ' ' . wp_required_field_message();
$class               = [ 'position-relative', 'comments', 'card', 'card-body', 'mt-4' ];
$classes             = apply_filters( 'isvek_theme_classes_comments', $class );
?>

	<section id="comments" class="<?php echo esc_attr( array_to_css_classes( $classes ) ); ?>" aria-label="<?php _e( 'Комментарии к записи', 'isvek' ); ?>">

		<?php if ( have_comments() ) : ?>

			<h2 class="comments-title fw-light fs-2 mb-3">

				<?php printf( '<span itemprop="commentCount">%d</span> %s', number_format_i18n( $get_comments_number ), esc_html( $num ) ); ?>

			</h2>

			<?php wp_list_comments( [
				'walker'      => new Isvek\Theme\Walker\Comment(),
				'type'        => 'comment',
				'callback'    => 'isvek_theme_comment',
				'style'       => 'div',
				'avatar_size' => 72,
				'max_depth'   => get_option( 'thread_comments_depth' ) ? get_option( 'thread_comments_depth' ) : - 1,
			], $comments ); ?>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<hr class="my-3 border-3">

				<?php isvek_theme_paginate_comments_links() ?>

			<?php endif; ?>

			<?php if ( ! comments_open() ) : ?>

				<div class="no-comments alert alert-info m-0 mt-3"><?php _e( 'Комментарии закрыты.', 'isvek' ); ?></div>

			<?php endif; ?>

		<?php endif; ?>

		<div class="my-2"></div>

		<?php
		comment_form(
			[
				'fields'              => apply_filters(
					'comment_form_default_fields',
					[
						'author'  => sprintf( '<div class="mb-3"><label for="author" class="form-label">%s%s</label><input id="author" name="author" class="form-control" type="text" value="%s" size="30"%s /></div>', __( 'Имя', 'isvek' ), ( $req ? $required_indicator : '' ), esc_attr( $commenter['comment_author'] ), ( $req ? ' required' : '' ) ),
						'email'   => sprintf( '<div class="mb-3"><label for="email" class="form-label">Email%s</label><input id="email" name="email" class="form-control" type="text" value="%s" size="30"%s /></div>', ( $req ? $required_indicator : '' ), esc_attr( $commenter['comment_author_email'] ), ( $req ? ' required' : '' ) ),
						'url'     => sprintf( '<div class="mb-3"><label for="url" class="form-label">%s</label><input id="url" name="url" class="form-control" type="url" value="%s" size="30" maxlength="200" autocomplete="url" /></div>', __( 'Сайт', 'isvek' ), esc_attr( $commenter['comment_author_url'] ) ),
						'cookies' => sprintf( '<div class="form-check mb-1"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"><label class="form-check-label" for="wp-comment-cookies-consent">%s</label></div>', __( 'Сохранить мое имя, электронную почту и веб-сайт в этом браузере для следующего комментария.', 'isvek' ), $consent )
					]
				),
				'class_container'     => 'comment-respond mt-2 mb-2',
				'format'              => 'html5',
				'cancel_reply_link'   => '<span class="text-danger d-inline-block"><i class="fa-solid fa-xmark me-1"></i>' . __( 'Отменить ответ', 'isvek' ) . '</span>',
				'cancel_reply_before' => '</h3>',
				'cancel_reply_after'  => '</div>',
				'title_reply'         => __( 'Добавить комментарий', 'isvek' ),
				'title_reply_before'  => '<div class="d-flex justify-content-between align-items-center mb-2"><h3 id="reply-title" class="comments-reply-title fw-light fs-4 p-0 m-0">',
				'title_reply_after'   => '',
				'submit_button'       => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
				'class_submit'        => 'btn btn-primary btn-sm',
				'submit_field'        => '<div class="text-end">%1$s %2$s</div>',
				'comment_field'       => '<div class="mb-3 form-floating comment-textarea"><textarea name="comment" id="comment" cols="45" rows="5" maxlength="65525" tabindex="0" class="textarea-comment form-control" aria-required="true" placeholder="' . __( 'Введите комментарий', 'isvek' ) . '" style="height: 100px" required></textarea><label for="comment" class="form-label">' . __( 'Комментарий', 'isvek' ) . '</label></div>'
			]
		);
		?>

	</section>

<?php


