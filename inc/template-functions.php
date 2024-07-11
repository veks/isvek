<?php
/**
 * Части шаблона isvek theme.
 *
 * @package Isvek\Theme\Template-parts
 * @version 1.0.0
 */

use Isvek\Theme\Breadcrumb;

if ( ! function_exists( 'isvek_theme_div_container' ) ) {

	/**
	 * Выводит контейнер div с классом, определенным в настройках темы.
	 *
	 * Эта функция выводит контейнер div с классом, определенным в настройках темы
	 * с помощью функции isvek_theme_get_option. Класс контейнера может быть изменен
	 * через настройки темы.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_div_container() {
		echo sprintf( '<div class="%s">', esc_attr( apply_filters( 'isvek_theme_classes_container', isvek_theme_get_option( 'content.container' ) ) ) );
	}
}

if ( ! function_exists( 'isvek_theme_div_main' ) ) {

	/**
	 * Выводит основной контейнер страницы (main) с указанными классами.
	 *
	 * Эта функция генерирует HTML код основного контейнера страницы с заданными классами.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_div_main() {
		echo '<main id="main" class="' . esc_attr( apply_filters( 'isvek_theme_classes_main', 'main site-main' ) ) . '" role="main">';
	}
}

if ( ! function_exists( 'isvek_theme_main_close' ) ) {

	/**
	 * Закрывает основной контейнер макета темы WordPress.
	 *
	 * Выводит закрывающий тег </main> для основного контейнера в макете темы.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_main_close() {
		echo '</main>';
	}
}

if ( ! function_exists( 'isvek_theme_header' ) ) {

	/**
	 * Выводит верхнюю часть шапки темы.
	 *
	 * Функция выводит HTML-код для тега <header> с классом, определенным фильтром 'isvekthemeclassesheader'.
	 * Если фильтр не определен, по умолчанию применяется класс 'site-header'.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_header() {
		echo '<header class="' . esc_attr( apply_filters( 'isvek_theme_classes_header', 'site-header' ) ) . '">';
	}
}

if ( ! function_exists( 'isvek_theme_header_close' ) ) {

	/**
	 * Закрывает хедер темы Isvek.
	 *
	 * Закрывает тег </header> для завершения хедера темы Isvek.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_header_close() {
		echo '</header>';
	}
}

if ( ! function_exists( 'isvek_theme_archive_title' ) ) {

	/**
	 * Выводит заголовок архива темы Isvek.
	 *
	 * Подключает шаблон 'template-parts/archive/title.php'.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_archive_title() {
		get_template_part( 'template-parts/archive/title' );
	}
}

if ( ! function_exists( 'isvek_theme_div_close' ) ) {

	/**
	 * Закрывает div элемент.
	 *
	 * Эта функция выводит закрывающий тег </div> при вызове.
	 * Она может быть использована для закрытия элемента <div> в вашей HTML структуре.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_div_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'isvek_theme_div_row' ) ) {

	/**
	 * Выводит HTML-тег div с классом строки.
	 *
	 * Эта функция выводит HTML-тег div с классом "row".
	 * Этот класс обычно используется в сетке Bootstrap для определения строки.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_div_row() {
		echo '<div class="row">';
	}
}

if ( ! function_exists( 'isvek_theme_div_col' ) ) {

	/**
	 * Выводит HTML-тег div с классом колонки.
	 *
	 * Эта функция выводит HTML-тег div с классом, который определяется функцией isvek_theme_get_col_class().
	 * Этот класс обычно используется для определения ширины колонки в сетке Bootstrap.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_div_col() {
		echo sprintf( '<div class="%s">', isvek_theme_get_col_class( false ) );
	}
}

if ( ! function_exists( 'isvek_theme_template_breadcrumb' ) ) {

	/**
	 * Функция для отображения хлебных крошек в теме isvek.
	 *
	 * Эта функция принимает массив аргументов в качестве параметра. Она создает новый объект Breadcrumb с переданными аргументами и вызывает метод render() этого объекта, чтобы отобразить хлебные крошки.
	 * Возвращаемое значение этой функции - это строка с HTML-кодом для отображения хлебных крошек или null, если хлебные крошки не могут быть отображены.
	 *
	 * @param array $args Массив аргументов для настройки отображения хлебных крошек.
	 *
	 * @since 1.0.0
	 *
	 * @return void Строка с HTML-кодом для отображения хлебных крошек или null, если хлебные крошки не могут быть отображены.
	 */
	function isvek_theme_template_breadcrumb( array $args = [] ) {
		( new Breadcrumb( $args ) )->render();
	}
}

if ( ! function_exists( 'isvek_theme_template_custom_logo' ) ) {

	/**
	 * Выводит пользовательский логотип темы.
	 *
	 * Функция выводит HTML-код для отображения пользовательского логотипа темы,
	 * используя настройки темы и функции WordPress для получения информации о логотипе.
	 *
	 * @since 1.0.4
	 *
	 * @return void Функция не возвращает значение.
	 */
	function isvek_theme_template_custom_logo(): void {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image          = wp_get_attachment_image(
			$custom_logo_id, 'full',
			false,
			[
				'alt' => get_bloginfo( 'name' ),
			]
		);

		echo sprintf( '%s', $image );
	}
}

if ( ! function_exists( 'isvek_theme_template_header' ) ) {

	/**
	 * Выводит шаблон с содержимым шапки темы.
	 *
	 * Функция использует функцию WordPress `get_template_part` для загрузки шаблона
	 * навигационной панели из файла 'template-parts/header/content.php' текущей темы.
	 *
	 * @since 1.0.0
	 *
	 * @return void Функция не возвращает значение.
	 */
	function isvek_theme_template_header() {
		get_template_part( 'template-parts/header/content' );
	}
}

if ( ! function_exists( 'isvek_theme_template_sidebar_left' ) ) {

	/**
	 * Выводит левую боковую панель темы.
	 *
	 * Функция использует функцию WordPress `get_sidebar` для загрузки шаблона
	 * левой боковой панели из файла 'sidebar-left.php' текущей темы.
	 *
	 * @since 1.0.0
	 *
	 * @return void Функция не возвращает значение.
	 */
	function isvek_theme_template_sidebar_left() {
		get_sidebar( 'left' );
	}
}

if ( ! function_exists( 'isvek_theme_template_sidebar_right' ) ) {

	/**
	 * Выводит правую боковую панель темы.
	 *
	 * Функция использует функцию WordPress `get_sidebar` для загрузки шаблона
	 * правой боковой панели из файла 'sidebar-right.php' текущей темы.
	 *
	 * @since 1.0.0
	 *
	 * @return void Функция не возвращает значение.
	 */
	function isvek_theme_template_sidebar_right() {
		get_sidebar( 'right' );
	}
}

if ( ! function_exists( 'isvek_theme_template_single_excerpt' ) ) {

	/**
	 * Выводит шаблон с отрывком записи.
	 *
	 * Эта функция выводит шаблон с отрывком записи, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/single.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_single_excerpt() {
		get_template_part( 'template-parts/single/excerpt' );
	}
}

if ( ! function_exists( 'isvek_theme_template_single_content' ) ) {

	/**
	 * Выводит шаблон с содержимым записи.
	 *
	 * Эта функция выводит шаблон с содержимым записи, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/single.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_single_content() {
		get_template_part( 'template-parts/single/content' );
	}
}

if ( ! function_exists( 'isvek_theme_template_page_content' ) ) {

	/**
	 * Выводит шаблон с содержимым страницы.
	 *
	 * Эта функция выводит шаблон с содержимым страницы, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/page.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_page_content() {
		get_template_part( 'template-parts/page/content' );
	}
}

if ( ! function_exists( 'isvek_theme_template_footer' ) ) {

	/**
	 * Выводит шаблон с содержимым подвала.
	 *
	 * Эта функция выводит шаблон с содержимым подвала, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/footer.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_footer() {
		get_template_part( 'template-parts/footer/content' );
	}
}

if ( ! function_exists( 'isvek_theme_template_scroll_top' ) ) {

	/**
	 * Выводит шаблон с кнопкой прокрутки вверх.
	 *
	 * Эта функция выводит шаблон с кнопкой прокрутки вверх, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/footer.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_scroll_top() {
		get_template_part( 'template-parts/footer/scroll-top' );
	}
}

if ( ! function_exists( 'isvek_theme_template_notices_cookies' ) ) {

	/**
	 * Выводит шаблон с уведомлением о файлах cookie.
	 *
	 * Эта функция выводит шаблон с уведомлением о файлах cookie, используя функцию get_template_part
	 * для загрузки шаблона из папки template-parts/footer.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_notices_cookies() {
		get_template_part( 'template-parts/footer/notices-cookies' );
	}
}

if ( ! function_exists( 'isvek_theme_template_pagination' ) ) {

	/**
	 * Выводит пагинацию.
	 *
	 * Эта функция выводит пагинацию, используя класс Isvek\Theme\Pagination для
	 * создания и отображения пагинации с переданными аргументами.
	 *
	 * @param array $args Массив аргументов для настройки пагинации.
	 *
	 * @since 1.0.0
	 *
	 */
	function isvek_theme_template_pagination( array $args = [] ) {
		( new Isvek\Theme\Pagination() )->render( $args );
	}
}

if ( ! function_exists( 'isvek_theme_pagination_page' ) ) {

	/**
	 * Функция для пагинации страниц в теме isvek.
	 *
	 * Эта функция использует глобальные переменные $page, $numpages, $multipage и $more. Она также устанавливает значения по умолчанию для аргументов пагинации, такие как текст перед и после пагинации, текст перед и после текущей страницы, формат ссылки на страницу и т. д.
	 * Затем аргументы фильтруются с помощью хука 'wp_link_pages_args' и преобразуются в объект. Если текущая страница не является многотомной, функция ничего не возвращает.
	 * Затем функция создает цикл for для перебора всех страниц и добавляет ссылки на каждую страницу в вывод. Если текущая страница не равна текущей странице в цикле или если $more равно false и текущая страница равна 1, то добавляется ссылка на страницу. В противном случае добавляется текст текущей страницы.
	 * В конце функция добавляет текст после пагинации и возвращает вывод.
	 *
	 * @param string $args Строка аргументов для настройки пагинации.
	 * @param string $output Строка вывода, которая будет изменена функцией.
	 *
	 * @since 1.0.0
	 *
	 * @return string|void Измененная строка вывода с пагинацией.
	 */
	function isvek_theme_pagination_page( string $output = '', string $args = '' ) {
		global $page, $numpages, $multipage, $more;

		$defaults = [
			'before'         => '<nav class="mt-4" aria-label="' . __( 'Навигация', 'isvek' ) . '" itemscope itemtype="https://schema.org/SiteNavigationElement" role="navigation"><ul class="pagination justify-content-center m-0">',
			'after'          => "</ul></nav>",
			'current_before' => '<li class="page-item active"><span itemprop="name" class="page-link">',
			'current_after'  => '</span></li>',
			'pagelink'       => '%',
			'link_before'    => '<li class="page-item">',
			'link_after'     => '</li>',
		];

		$args = (object) apply_filters( 'wp_link_pages_args', wp_parse_args( $args, $defaults ) );

		if ( ! $multipage ) {
			return;
		}

		$output = $args->before;

		for ( $i = 1; $i < $numpages + 1; $i ++ ) {
			$j      = str_replace( '%', $i, $args->pagelink );
			$output .= '';

			if ( $i !== $page || ! $more && 1 === $page ) {
				$link   = str_replace( 'post-page-numbers', 'page-numbers page-link', _wp_link_page( $i ) );
				$link   = str_replace( '<a', '<a itemprop="url"', $link );
				$output .= sprintf(
					'%1$s%2$s%3$s</a>%4$s',
					$args->link_before,
					$link,
					$j,
					$args->link_after
				);
			} else {
				$output .= sprintf(
					'%1$s%2$s%3$s',
					$args->current_before,
					$j,
					$args->current_after
				);
			}
		}

		$output .= $args->after;

		return $output;
	}

	add_filter( 'wp_link_pages', 'isvek_theme_pagination_page' );
}

if ( ! function_exists( 'isvek_theme_paginate_comments_links' ) ) {

	/**
	 * Функция для пагинации ссылок на комментарии в теме isvek.
	 *
	 * Эта функция использует глобальную переменную $wp_rewrite и проверяет, является ли текущая страница отдельной страницей. Если это не так, функция ничего не возвращает.
	 * Затем функция получает текущую страницу комментариев и максимальное количество страниц комментариев. Она также устанавливает значения по умолчанию для аргументов пагинации, такие как базовый URL, формат, общее количество страниц, текущую страницу и т. д.
	 * Если используются постоянные ссылки, базовый URL изменяется соответствующим образом. Затем аргументы сливаются с аргументами по умолчанию и передаются в функцию isvek_theme_pagination для отображения пагинации.
	 *
	 * @param array $args Массив аргументов для настройки пагинации.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function isvek_theme_paginate_comments_links( array $args = [] ) {
		global $wp_rewrite;

		if ( ! is_singular() ) {
			return;
		}

		$page = get_query_var( 'cpage' );

		if ( ! $page ) {
			$page = 1;
		}

		$max_page = get_comment_pages_count();
		$defaults = [
			'base'         => add_query_arg( 'cpage', '%#%' ),
			'format'       => '',
			'total'        => $max_page,
			'current'      => $page,
			'echo'         => true,
			'add_fragment' => '#comments',
			'aria_label'   => __( 'Навигация по комментариям', 'isvek' ),
		];

		if ( $wp_rewrite->using_permalinks() ) {
			$defaults['base'] = user_trailingslashit( trailingslashit( get_permalink() ) . $wp_rewrite->comments_pagination_base . '-%#%', 'commentpaged' );
		}

		$args = wp_parse_args( $args, $defaults );

		isvek_theme_template_pagination( $args );
	}
}

if ( ! function_exists( 'isvek_theme_comment' ) ) {

	/**
	 * Функция для отображения комментария в теме isvek.
	 *
	 * Эта функция принимает объект WP_Comment, массив аргументов и глубину вложенности комментария в качестве параметров. Она использует данные из объекта WP_Comment, чтобы определить, имеет ли комментарий родительский комментарий, и добавляет соответствующие атрибуты и метатеги.
	 * Затем функция определяет тег, который будет использоваться для обертки комментария, и устанавливает значения для некоторых переменных, таких как $add_below и $mt. Она также получает URL автора комментария, имя автора комментария, аватар автора комментария и ссылку для ответа на комментарий.
	 * Затем функция выводит HTML-код для отображения комментария, включая аватар автора комментария, имя автора комментария, дату и время создания комментария, текст комментария и ссылку для ответа на комментарий. Если комментарий еще не был одобрен, выводится сообщение об этом.
	 *
	 * @param array $args Массив аргументов для настройки отображения комментария.
	 * @param int $depth Глубина вложенности комментария.
	 * @param WP_Comment $comment Объект WP_Comment с данными о комментарии.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_comment( WP_Comment $comment, array $args, int $depth ) {
		$data_comment_parent_id = $comment->comment_parent > 0 ? " data-parent='{$comment->comment_parent}'" : '';
		$meta_comment_parent_id = $comment->comment_parent > 0 ? "<meta itemprop='parentItem' content='{$comment->comment_parent}'>" : '';
		$tag                    = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$add_below              = 'comment';
		$mt                     = $depth > 1 ? 'mt-2' : 'mt-0';
		$parent                 = empty( $args['has_children'] ) ? '' : ' parent';
		$comment_author_url     = get_comment_author_url( $comment );
		$comment_author         = get_comment_author( $comment );
		$avatar                 = get_avatar( $comment, $args['avatar_size'], '', '',
			[ 'class' => 'border rounded-circle shadow-1-strong me-3' ] );
		$comment_reply_link     = get_comment_reply_link(
			array_merge(
				$args,
				[
					'add_below'  => $add_below,
					'reply_text' => '<i class="fas fa-reply me-1 fs-6"></i><span class="d-none d-lg-inline small">' . __( 'Ответить',
							'isvek' ) . '</span>',
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'before'     => '<div>',
					'after'      => '</div>',
				]
			)
		);
		?>

		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( array_to_css_classes(
			[
				'mb-1 d-flex flex-start',
				$mt,
				$parent,
			] ) ) . $data_comment_parent_id; ?>>

		<?php echo $meta_comment_parent_id; ?>

		<?php if ( ! empty( $avatar ) ) : ?>
			<?php echo wp_kses_post( $avatar ); ?>
		<?php endif; ?>

		<div class="flex-grow-1 flex-shrink-1">
		<div class="bg-light rounded-start-top-0 p-3 rounded">
			<div class="d-flex justify-content-between mb-2">
				<div>
					<?php if ( ! empty( get_comment_link( $comment->comment_ID ) ) ) : ?>
						<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>"
						   class="">
							 <span class="fw-bolder " itemprop="author" itemscope itemtype="https://schema.org/Person">
								<?php echo esc_html( $comment_author ); ?>
							 </span>
						</a>
					<?php else: ?>
						<span class="fw-bolder" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<?php echo esc_html( $comment_author ); ?>
						</span>
					<?php endif; ?>

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<span
							class="small text-danger"><?php _e( 'Ваш комментарий ожидает модерации',
								'isvek' ); ?>.</span>
					<?php endif; ?>

					<div class="d-flex align-items-center text-dark small">
						<span class="me-1"><?php _e( 'Опубликовано', 'isvek' ); ?>:</span>
						<div itemprop="dateCreated" class="comment-created on text-muted">
							<?php echo get_comment_date( 'd M Y,', $comment ) . ' в ' . get_comment_time(); ?>
						</div>
						<div class="ms-1 me-1">-</div>
						<div>
							<span
								class="text-muted"> <?php echo human_time_diff( get_comment_time( 'U' ),
										current_time( 'timestamp' ) ) . ' назад'; ?> </span>
						</div>
					</div>
				</div>
				<div class="d-flex flex-row mb-1">
					<?php edit_comment_link( '<i class="fas fa-edit me-1 fs-6"></i><span class="d-none d-lg-inline small">' . __( 'Редактировать',
							'isvek' ) . '</span>', '<div class="me-2">', '</div>' ); ?>
					<?php echo $comment_reply_link; ?>
				</div>
			</div>
			<div class="text-break p-0 m-0" itemprop="text">
				<?php comment_text(
					$comment,
					array_merge(
						$args,
						[
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						]
					)
				); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'isvek_theme_reorder_comment_fields' ) ) {

	/**
	 * Функция для изменения порядка полей формы комментария в теме isvek.
	 *
	 * Эта функция принимает массив полей формы комментария в качестве параметра. Она создает новый массив $new_fields и устанавливает порядок полей с помощью массива $order_fields.
	 * Затем функция перебирает элементы массива $order_fields и, если соответствующее поле существует в исходном массиве $fields, добавляет его в новый массив $new_fields и удаляет из исходного массива.
	 * Если в исходном массиве остались поля, которые не были упорядочены, они добавляются в конец нового массива. В конце функция возвращает новый массив с измененным порядком полей.
	 *
	 * @param array $fields Массив полей формы комментария.
	 *
	 * @since 1.0.0
	 *
	 * @return array Массив с измененным порядком полей.
	 */
	function isvek_theme_reorder_comment_fields( array $fields ): array {
		$new_fields   = [];
		$order_fields = [ 'author', 'email', 'url', 'comment', 'cookies' ];

		foreach ( $order_fields as $key ) {
			if ( isset( $fields[ $key ] ) ) {
				$new_fields[ $key ] = $fields[ $key ];

				unset( $fields[ $key ] );
			}
		}

		if ( $fields ) {
			foreach ( $fields as $key => $val ) {
				$new_fields[ $key ] = $val;
			}
		}

		return $new_fields;
	}

	add_filter( 'comment_form_fields', 'isvek_theme_reorder_comment_fields' );
}

if ( ! function_exists( 'isvek_theme_required_field_indicator' ) ) {

	/**
	 * Функция для отображения индикатора обязательного поля в теме isvek.
	 *
	 * Эта функция не принимает никаких параметров. Она возвращает строку с HTML-кодом, который отображает красный символ звездочки, указывающий на то, что поле является обязательным для заполнения.
	 *
	 * @since 1.0.0
	 *
	 * @return string Строка с HTML-кодом для отображения индикатора обязательного поля.
	 */
	function isvek_theme_required_field_indicator(): string {
		return '<span class="text-danger">*</span>';
	}

	add_filter( 'wp_required_field_indicator', 'isvek_theme_required_field_indicator' );
}

if ( ! function_exists( 'isvek_theme_previous_comments_link_attributes' ) ) {

	/**
	 * Функция для добавления атрибутов к ссылке на предыдущие комментарии в теме isvek.
	 *
	 * Эта функция не принимает никаких параметров. Она возвращает строку с атрибутами, которые будут добавлены к ссылке на предыдущие комментарии. В данном случае добавляется атрибут class со значением "page-link".
	 *
	 * @since 1.0.0
	 *
	 * @return string Строка с атрибутами для ссылки на предыдущие комментарии.
	 */
	function isvek_theme_comments_link_attributes(): string {
		return 'class="page-link"';
	}

	add_filter( 'previous_comments_link_attributes', 'isvek_theme_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'isvek_theme_comments_link_attributes' );
}

if ( ! function_exists( 'isvek_theme_template_skip_link' ) ) {

	/**
	 * Функция для перехода к содержимому.
	 *
	 * Эта функция не принимает никаких параметров. Она возвращает ссылку.
	 *
	 * @since 1.0.0
	 */
	function isvek_theme_template_skip_link() {
		echo '<a class="skip-link screen-reader-text" href="#content">' . __( 'Перейти к содержимому', 'isvek' ) . '</a>';
	}
}

if ( ! function_exists( 'isvek_theme_template_title_tag' ) ) {

	/**
	 * Выводит тег заголовка, если текущая тема поддерживает 'title-tag'.
	 *
	 * Эта функция проверяет, поддерживает ли текущая тема 'title-tag'. Если поддерживает,
	 * она выводит тег заголовка с использованием wp_get_document_title() для получения заголовка документа.
	 *
	 * @since 1.0.4
	 *
	 * @return void
	 */
	function isvek_theme_template_title_tag() {
		if ( ! current_theme_supports( 'title-tag' ) ) {
			return;
		}

		$title = sprintf( '<%1$s itemprop="headline">%2$s</%1$s>%3$s', 'title', wp_get_document_title(), "\n" );

		echo apply_filters( 'isvek_theme_template_title_tag', $title, wp_get_document_title() );
	}
}
