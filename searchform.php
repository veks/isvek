<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Isvek\Theme
 * @since 1.0.0
 */

?>

<form class="isvek-theme-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">

	<div class="input-group">

		<label for="s"></label>

		<input type="text" name="s" id="s" class="form-control rounded-start search-input" value="<?php echo get_search_query(); ?>" placeholder="<?php _e( 'Введите запрос', 'isvek' ); ?>" list="isvek-theme-search-data-list">

		<datalist id="isvek-theme-search-data-list"></datalist>

		<button type="submit" class="btn btn-primary" aria-label="Поиск">

			<i class="fa-solid fa-magnifying-glass"></i>

		</button>

	</div>

</form>
