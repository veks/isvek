<?php
/**
 * Customize class.
 *
 * @class   Customize
 * @version 1.0.0
 * @package Isvek\Theme\Customize
 */

namespace Isvek\Theme\Customize;

use Isvek\Theme\Bootstrap;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Customize\Customize' ) ) {

	/**
	 * Customize class.
	 */
	class Customize extends Bootstrap {

		/**
		 * @var string
		 */
		protected string $customize_panel;

		/**
		 * @var string
		 */
		protected string $customize_panel_sidebar;

		/**
		 * @var string
		 */
		protected string $customize_section_header;

		/**
		 * @var string
		 */
		protected string $customize_section_sidebar;

		/**
		 * @var string
		 */
		protected string $customize_section_content;

		/**
		 * @var string
		 */
		protected string $customize_section_footer;

		/**
		 * @return string|mixed
		 */
		protected string $slug;

		/**
		 * Конструктор класса.
		 *
		 * Инициализирует свойства класса, и добавляет действие 'customize_register' в WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->customize_panel           = 'isvek-theme-panel';
			$this->customize_panel_sidebar   = 'isvek-theme-panel-sidebar';
			$this->customize_section_sidebar = 'isvek-theme-section-sidebar';
			$this->customize_section_header  = 'isvek-theme-section-header';
			$this->customize_section_content = 'isvek-theme-section-content';
			$this->customize_section_footer  = 'isvek-theme-section-footer';

			add_action( 'customize_register', [ $this, 'customize_register' ] );
		}

		/**
		 * Регистрирует настройки темы в Кастомайзере WordPress.
		 *
		 * Эта функция добавляет различные настройки и контролы в Кастомайзер WordPress.
		 * Она использует WP_Customize_Manager $wp_customize для добавления и управления настройками и контролами.
		 *
		 * @param WP_Customize_Manager $wp_customize Объект менеджера настроек WordPress.
		 *
		 * @since 1.0.0
		 */
		public function customize_register( WP_Customize_Manager $wp_customize ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				[
					'selector' => 'a.navbar-brand',
				]
			);

			$wp_customize->selective_refresh->add_partial(
				'custom_logo',
				[
					'selector'            => 'a.navbar-brand-item',
					'container_inclusive' => true,
				]
			);

			$wp_customize->selective_refresh->add_partial(
				'nav_menu_locations[isvek-theme-header-nav-menu]',
				[
					'selector'            => '.navbar-nav',
					'container_inclusive' => true,
				]
			);

			/**
			 * Panel settings isvek theme.
			 */
			$wp_customize->add_panel(
				$this->customize_panel,
				[
					'title'       => __( 'Настройки темы', 'isvek' ),
					'description' => __( 'Все возможные настройки', 'isvek' ),
					'capability'  => 'edit_theme_options',
					'priority'    => 10,
				]
			);

			/**
			 * Section navbar.
			 *
			 * @url customize.php?autofocus[section]=isvek-theme-section-header
			 */
			$wp_customize->add_section(
				$this->customize_section_header,
				[
					'title'      => __( 'Настройки шапки', 'isvek' ),
					'panel'      => $this->customize_panel,
					'capability' => 'edit_theme_options',
					'priority'   => 1,
				]
			);

			/**
			 * Section content.
			 *
			 * @url customize.php?autofocus[section]=isvek-theme-section-content
			 */
			$wp_customize->add_section(
				$this->customize_section_content,
				[
					'title'      => __( 'Настройки контента', 'isvek' ),
					'panel'      => $this->customize_panel,
					'capability' => 'edit_theme_options',
					'priority'   => 2,
				]
			);

			/**
			 * Section footer.
			 *
			 * @url customize.php?autofocus[section]=isvek-theme-section-footer
			 */
			$wp_customize->add_section(
				$this->customize_section_footer,
				[
					'title'      => __( 'Настройки подвала', 'isvek' ),
					'panel'      => $this->customize_panel,
					'capability' => 'edit_theme_options',
					'priority'   => 3,
				]
			);

			/**
			 * Section header expand.
			 */
			$wp_customize->add_setting(
				'isvek-theme[header][navbar][display-brand]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'header.navbar.display-brand' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-header-navbar-display-brand',
				[
					'label'    => __( 'Бренд', 'isvek' ),
					'section'  => $this->customize_section_header,
					'settings' => 'isvek-theme[header][navbar][display-brand]',
					'type'     => 'select',
					'choices'  => [
						0 => __( 'Выключить', 'isvek' ),
						1 => __( 'Включить', 'isvek' ),
					],
					'priority' => 3,
				]
			);

			/**
			 * Section header expand.
			 */
			$wp_customize->add_setting(
				'isvek-theme[header][navbar][expand]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'header.navbar.expand' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-header-navbar-expand',
				[
					'label'       => __( 'Меню', 'isvek' ),
					'description' => __( 'Выберите мультимедийный запрос, в котором вы хотите отобразить меню.',
						'isvek' ),
					'section'     => $this->customize_section_header,
					'settings'    => 'isvek-theme[header][navbar][expand]',
					'type'        => 'select',
					'choices'     => [
						'navbar-expand-sm'  => __( 'от - 576px', 'isvek' ),
						'navbar-expand-md'  => __( 'от - 768px', 'isvek' ),
						'navbar-expand-lg'  => __( 'от - 992px', 'isvek' ),
						'navbar-expand-xl'  => __( 'от - 1200px', 'isvek' ),
						'navbar-expand-xxl' => __( 'от - 1400px', 'isvek' ),
					],
					'priority'    => 3,
				]
			);

			/**
			 * Section header alignment.
			 */
			$wp_customize->add_setting(
				'isvek-theme[header][navbar][alignment]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'header.navbar.alignment' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-header-navbar-alignment',
				[
					'label'       => __( 'Расположение меню', 'isvek' ),
					'description' => __( 'Выберите расположение меню.', 'isvek' ),
					'section'     => $this->customize_section_header,
					'settings'    => 'isvek-theme[header][navbar][alignment]',
					'type'        => 'select',
					'choices'     => [
						'justify-content-start'  => __( 'Слева', 'isvek' ),
						'justify-content-center' => __( 'Центр', 'isvek' ),
						'justify-content-end'    => __( 'Справа', 'isvek' ),
					],
					'priority'    => 4,
				]
			);

			/**
			 * Section header offcanvas.
			 */
			$wp_customize->add_setting(
				'isvek-theme[header][navbar][offcanvas]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'header.navbar.offcanvas' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-header-navbar-offcanvas',
				[
					'label'       => __( 'Размещение меню', 'isvek' ),
					'description' => __( 'Выберите мультимедийный запрос, в котором вы хотите отобразить меню.',
						'isvek' ),
					'section'     => $this->customize_section_header,
					'settings'    => 'isvek-theme[header][navbar][offcanvas]',
					'type'        => 'select',
					'choices'     => [
						'offcanvas-start'  => __( 'Размещает меню слева от области просмотра', 'isvek' ),
						'offcanvas-end'    => __( 'Размещает меню справа от области просмотра', 'isvek' ),
						'offcanvas-top'    => __( 'Помещает меню в верхнюю часть области просмотра', 'isvek' ),
						'offcanvas-bottom' => __( 'Помещает меню в нижнюю часть области просмотра', 'isvek' ),
					],
					'priority'    => 5,
				]
			);

			/**
			 * Content DEBUG
			 */
			$wp_customize->add_setting(
				'isvek-theme[content][debug]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'content.debug' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-content-debug',
				[
					'label'       => __( 'Отлаживать', 'isvek' ),
					'description' => __( 'Показывает исходный код js скриптов и css стилей.', 'isvek' ),
					'section'     => 'isvek-theme-section-content',
					'settings'    => 'isvek-theme[content][debug]',
					'type'        => 'select',
					'choices'     => [
						0 => __( 'Выключить', 'isvek' ),
						1 => __( 'Включить', 'isvek' ),
					],
					'priority'    => 1,
				]
			);

			/**
			 * Content search
			 */
			$wp_customize->add_setting(
				'isvek-theme[content][search]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'content.search' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-content-search',
				[
					'label'       => __( 'Поиск', 'isvek' ),
					'description' => __( 'Включить или отключить поиск на сайте.', 'isvek' ),
					'section'     => 'isvek-theme-section-content',
					'settings'    => 'isvek-theme[content][search]',
					'type'        => 'select',
					'choices'     => [
						0 => __( 'Выключить', 'isvek' ),
						1 => __( 'Включить', 'isvek' ),
					],
					'priority'    => 2,
				]
			);

			/**
			 * Content container
			 */
			$wp_customize->add_setting(
				'isvek-theme[content][container]',
				[
					'type'              => 'option',
					'default'           => isvek_theme_get_option( 'content.container' ),
					'transport'         => 'refresh',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			$wp_customize->add_control(
				'isvek-theme-control-content-container',
				[
					'label'       => __( 'Отзывчивые контейнеры', 'isvek' ),
					'description' => __( 'Отзывчивые контейнеры позволяют вам указать класс шириной 100%, пока не будет достигнута указанная точка останова, после чего мы применяем max-widths для каждой из более высоких точек останова. Например, .container-sm имеет ширину 100 % для начала до достижения sm точки останова, где она будет масштабироваться с помощью md, lg, xlи xxl.',
						'isvek' ),
					'section'     => 'isvek-theme-section-content',
					'settings'    => 'isvek-theme[content][container]',
					'type'        => 'select',
					'choices'     => [
						'container'       => __( 'По умолчанию', 'isvek' ),
						'container-sm'    => __( 'Ширина 100% до небольшой точки останова', 'isvek' ),
						'container-md'    => __( 'Ширина 100% до средней точки останова', 'isvek' ),
						'container-lg'    => __( 'Ширина 100% до большой точки останова', 'isvek' ),
						'container-xl'    => __( 'Ширина 100% до очень большой точки останова', 'isvek' ),
						'container-xxl'   => __( 'Ширина 100% до очень большой точки останова', 'isvek' ),
						'container-fluid' => __( 'Ширина 100% на всю ширину', 'isvek' ),
					],
					'priority'    => 4,
				]
			);
		}
	}
}
