<?php
/**
 * Loader class.
 *
 * Класс загрузчика для этой тем.
 *
 * @class   Loader
 * @version 1.0.0
 * @package Isvek\Theme
 */

namespace Isvek\Theme;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Isvek\Theme\Loader' ) ) {

	/**
	 * Loader class.
	 */
	class Loader {

		/**
		 * @since 1.0.0
		 *
		 * @var array|string[]
		 */
		protected array $classes;

		/**
		 * Метод `get` возвращает массив классов, установленных для объекта Loader.
		 *
		 * Описание:
		 * Этот метод используется для получения массива классов, которые были установлены
		 * для объекта Loader. Массив содержит список классов, представленных в виде строки.
		 *
		 * @since 1.0.0
		 *
		 * @return array Массив классов, установленных для объекта Loader.
		 */
		public function get(): array {
			// Возвращаем массив классов, сохраненных в свойстве $classes объекта Loader.
			return $this->classes;
		}

		/**
		 * Метод `set` устанавливает классы для объекта Loader.
		 *
		 * Описание:
		 * Этот метод используется для установки массива классов для объекта Loader. Метод принимает
		 * массив классов в качестве параметра и заменяет текущий список классов новыми.
		 *
		 * @since 1.0.0
		 *
		 * @param array $classes Массив классов для установки.
		 *
		 * @return Loader Возвращает объект Loader с обновленным списком классов.
		 */
		public function set( array $classes ): Loader {
			// Заменяем текущий список классов новыми классами из массива $classes.
			$this->classes = array_merge( [], $classes );

			// Возвращаем объект Loader с обновленным списком классов.
			return $this;
		}

		/**
		 * Метод `remove` удаляет указанные классы из объекта Loader.
		 *
		 * Описание:
		 * Этот метод используется для удаления одного или нескольких классов из списка классов,
		 * установленных для объекта Loader. Метод принимает классы для удаления в виде
		 * одиночной строки или массива и обновляет список классов без указанных классов.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed $unsetClasses Классы для удаления. Может быть строкой (одиночным классом)
		 *                           или массивом классов.
		 *
		 * @return void
		 */
		public function remove( $unsetClasses ) {
			// Проверяем, существует ли список классов в объекте Loader.
			if ( ! isset( $this->classes ) ) {
				return;
			}

			// Создаем обратный массив, где ключи - это классы, а значения - их индексы в массиве.
			$classFlip = array_flip( $this->classes );

			// Проверяем, является ли $unsetClasses массивом.
			if ( is_array( $unsetClasses ) ) {
				foreach ( $unsetClasses as $class ) {
					// Проверяем, существует ли класс в списке.
					if ( isset( $classFlip[ $class ] ) ) {
						// Удаляем класс из списка.
						unset( $this->classes[ $classFlip[ $class ] ] );
					}
				}
			} else {
				// Удаляем одиночный класс из списка.
				if ( isset( $classFlip[ $unsetClasses ] ) ) {
					unset( $this->classes[ $classFlip[ $unsetClasses ] ] );
				}
			}
		}

		/**
		 * Инициализирует и возвращает массив классов.
		 *
		 * Эта функция проходит через все классы, указанные в $this->classes. Если класс существует,
		 * он создает новый экземпляр этого класса и добавляет его в массив $classes.
		 * Затем она проверяет, есть ли у нового класса свойство classes_boot. Если это так,
		 * она создает новые экземпляры этих классов и добавляет их в массив $classes.
		 *
		 * @since 1.0.0
		 *
		 * @return array Массив объектов классов.
		 */
		public function init(): array {
			$classes = [];

			if ( ! empty( $this->classes ) ) {
				foreach ( $this->classes as $class ) {
					if ( class_exists( $class ) ) {
						$classes[] = new $class();
					}
				}
			}

			return $classes;
		}
	}
}
