<?php
/**
 * Функции isvek theme.
 *
 * @package Isvek\Theme\Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'isvek_theme_get_col_class' ) ) {

	/**
	 * Возвращает или выводит класс колонки, определенный в настройках темы.
	 *
	 * Эта функция возвращает или выводит класс колонки, определенный в настройках темы
	 * в зависимости от активности боковых панелей и текущей страницы. Класс колонки
	 * может быть изменен через настройки темы.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $echo Определяет, следует ли выводить класс колонки (true) или возвращать его (false).
	 *
	 * @return string|null|void Возвращает класс колонки, если $echo равно false. В противном случае ничего не возвращает.
	 */
	function isvek_theme_get_col_class( bool $echo = true ) {
		if ( is_active_sidebar( 'isvek-sidebar-right' ) && is_active_sidebar( 'isvek-sidebar-left' ) && ! is_404() ) {
			$col = 'col-12 col-lg-6 col-xl-6 col-xxl-6 order-first';
		} elseif ( is_active_sidebar( 'isvek-sidebar-right' ) && ! is_404() ) {
			$col = 'col-12 col-lg-9 col-xl-9 col-xxl-9 order-first';
		} elseif ( is_active_sidebar( 'isvek-sidebar-left' ) && ! is_404() ) {
			$col = 'col-12 col-lg-9 col-xl-9 col-xxl-9 order-first';
		} else {
			$col = 'col-12';
		}

		if ( $echo ) {
			echo sprintf( '%s', esc_attr( $col ) );
		} else {
			return esc_attr( $col );
		}
	}
}

if ( ! function_exists( 'isvek_theme_get_option' ) ) {

	/**
	 * Возвращает значение опции темы по ключу.
	 *
	 * Функция извлекает значение опции темы по указанному ключу, если значение не найдено, возвращает значение по умолчанию.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Ключ опции.
	 * @param bool $default Значение по умолчанию, которое будет возвращено, если опция не найдена.
	 *
	 * @return mixed          Значение опции темы или значение по умолчанию.
	 */
	function isvek_theme_get_option( string $key = '', bool $default = false ) {
		$get_option = get_option( ISVEK_THEME_OPTION_NAME );

		return array_get( $get_option, $key, $default );
	}
}

if ( ! function_exists( 'isvek_theme_update_option' ) ) {

	/**
	 * Обновляет опцию темы.
	 *
	 * Функция обновляет заданную опцию темы в базе данных.
	 * Если опция с заданным ключом существует, ее значение будет обновлено,
	 * в противном случае будет создана новая опция с указанным ключом и значением.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Ключ опции, которую необходимо обновить.
	 * @param string $value Новое значение для опции.
	 */
	function isvek_theme_update_option( string $key = '', string $value = '' ) {
		$get_option = get_option( ISVEK_THEME_OPTION_NAME );
		$data       = data_set( $get_option, $key, $value );

		update_option( ISVEK_THEME_OPTION_NAME, $data );
	}
}

if ( ! function_exists( 'isvek_theme_get_option_db' ) ) {

	/**
	 * Получает значение опции из базы данных темы.
	 *
	 * Функция извлекает значение опции из таблицы базы данных WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Необязательный. Ключ опции, значение которой нужно получить. По умолчанию ''.
	 * @param mixed $default Необязательный. Значение по умолчанию, возвращаемое, если опция не найдена. По умолчанию false.
	 *
	 * @return mixed            Значение опции, если оно существует; в противном случае возвращается значение по умолчанию.
	 */
	function isvek_theme_get_option_db( string $key = '', $default = false ) {
		global $wpdb;

		$option = $wpdb->get_var( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s", ISVEK_THEME_OPTION_NAME ) );
		$option = maybe_unserialize( $option );

		return array_get( $option, $key, $default );
	}
}

if ( ! function_exists( 'isvek_theme_num_decline' ) ) {

	/**
	 * Склоняет числительное в зависимости от числа.
	 *
	 * Эта функция склоняет числительное в зависимости от числа, используя массив
	 * заголовков для разных склонений. Может быть использована для правильного
	 * отображения числительных в тексте.
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $titles Массив заголовков для разных склонений или строка с заголовками, разделенными запятой.
	 * @param bool $show_number Определяет, следует ли выводить число перед числительным (true) или нет (false).
	 * @param string $number Число, для которого нужно склонять числительное.
	 *
	 * @return string Возвращает строку с числительным, склоненным в зависимости от числа.
	 */
	function isvek_theme_num_decline( string $number, $titles, bool $show_number = false ): string {
		if ( is_string( $titles ) ) {
			$titles = preg_split( '/, */', $titles );
		}

		if ( empty( $titles[2] ) ) {
			$titles[2] = $titles[1];
		}

		$cases       = [ 2, 0, 1, 1, 1, 2 ];
		$int_num     = abs( (int) strip_tags( $number ) );
		$title_index = ( $int_num % 100 > 4 && $int_num % 100 < 20 ) ? 2 : $cases[ min( $int_num % 10, 5 ) ];

		return ( $show_number ? $number . ' ' : '' ) . $titles[ $title_index ];
	}
}

if ( ! function_exists( 'isvek_theme_print_r' ) ) {

	/**
	 * Выводит информацию о переменной в удобном для чтения формате.
	 *
	 * Эта функция выводит информацию о переменной в удобном для чтения формате,
	 * используя функцию print_r. Функция доступна только для пользователей с ролью
	 * администратора.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $return Определяет, следует ли возвращать информацию (true) или выводить ее (false).
	 * @param mixed $value Переменная, информацию о которой нужно вывести.
	 */
	function isvek_theme_print_r( $value, bool $return = true ) {
		if ( current_user_can( 'administrator' ) ) {
			echo '<pre>' . print_r( $value, $return ) . '</pre>';
		}
	}
}

