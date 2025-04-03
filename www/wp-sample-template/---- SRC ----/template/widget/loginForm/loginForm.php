<?php

/**
 * Класс для создания виджета "Форма входа".
 */
class LoginForm extends WP_Widget {

	/**
	 * Конструктор класса.
	 * Инициализирует базовые настройки виджета.
	 */
	public function __construct() {
		parent::__construct(
			'login_form', // Идентификатор виджета
			esc_html__( 'Login Form', '<%= theme %>' ), // Название виджета
			array( 'description' => esc_html__( 'Login Form', '<%= theme %>' ) ) // Описание виджета
		);
	}

	/**
	 * Метод для отображения фронтенда виджета.
	 * Здесь выводится контент виджета на сайте.
	 *
	 * @param array $args Аргументы виджета.
	 * @param array $instance Настройки виджета.
	 */
	public function widget( $args, $instance ) {
		// Получение настроек виджета
		$title_form = isset( $instance['title_form'] ) ? $instance['title_form'] : '';

		// URL-адреса
		$home_url = home_url();

		// Вывод начального HTML-кода виджета
		echo $args['before_widget'];


		echo $args['before_title'];
		// Проверка, авторизован ли пользователь
		if ( is_user_logged_in() ) {
			// Вывод заголовка виджета для авторизованного пользователя
			?>
			<a href="<?php echo admin_url() ?>"><?php echo wp_get_current_user()->display_name ?></a>
			<?php
		} else {
			// Вывод заголовка виджета для неавторизованного пользователя
			echo "<span>$title_form</span>";
		}
		echo $args['after_title'];

		// Форма входа из inc/s-login
		echo get_s_login();

		// Вывод завершающего HTML-кода виджета
		echo $args['after_widget'];
	} // Конец метода widget

	/**
	 * Метод для отображения бэкенда виджета.
	 * Здесь создаются поля для настроек виджета.
	 *
	 * @param array $instance Настройки виджета.
	 */
	public function form( $instance ) {
		// Установка значений по умолчанию, если они не заданы
		$title_form = isset( $instance['title_form'] ) ? $instance['title_form'] : '';
		?>
		<!-- Поле для заголовка формы -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_form' ) ); ?>"><?php esc_html_e( 'Heading', '<%= theme %>' ); ?></label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title_form' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title_form' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title_form ); ?>" />
		</p>
		<?php
	} // Конец метода form

	/**
	 * Метод для сохранения настроек виджета.
	 * Здесь происходит обработка данных, введенных пользователем.
	 *
	 * @param array $new_instance Новые настройки виджета.
	 * @param array $old_instance Старые настройки виджета.
	 * @return array Обновленные настройки виджета.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		// Проверка и сохранение переменных
		$instance['title_form'] = strip_tags( $new_instance['title_form'] );

		return $instance;
	} // Конец метода update

} // Конец класса LoginForm

/**
 * Функция для регистрации виджета.
 * Эта функция вызывается при инициализации виджетов.
 */
if ( ! function_exists( '<%= theme %>_login_form_load' ) ) {
	function <%= theme %>_login_form_load() {
		register_widget( 'LoginForm' );
	}
}
add_action( 'widgets_init', '<%= theme %>_login_form_load' );

?>