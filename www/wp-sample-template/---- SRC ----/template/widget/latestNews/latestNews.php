<?php

/**
 * Класс для создания виджета "Последние новости".
 */
class LatestNews extends WP_Widget {

	/**
	 * Конструктор класса.
	 * Инициализирует базовые настройки виджета.
	 */
	public function __construct() {
		parent::__construct(
			'latest_news', // Идентификатор виджета
			esc_html__( 'Latest news', '<%= theme %>' ), // Название виджета
			array( 'description' => esc_html__( 'Latest news', '<%= theme %>' ) ) // Описание виджета
		);
	}

	/**
	 * Метод для отображения бэкенда виджета.
	 * Здесь создаются поля для настроек виджета.
	 *
	 * @param array $instance Настройки виджета.
	 */
	public function form( $instance ) {
		// Установка значений по умолчанию, если они не заданы
		$title_widget  = isset( $instance['title_widget'] )  ? $instance['title_widget']  : '';
		$widget_num    = isset( $instance['widget_num'] )    ? $instance['widget_num']    : 5;
		$widget_img    = isset( $instance['widget_img'] )    ? $instance['widget_img']    : 1;
		$post_category = isset( $instance['post_category'] ) ? $instance['post_category'] : 0;
		?>

		<!-- Поле для заголовка виджета -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_widget' ) ); ?>"><?php esc_html_e( 'Heading', '<%= theme %>' ); ?></label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title_widget' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title_widget' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title_widget ); ?>" />
		</p>

		<!-- Поле для количества новостей -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_num' ) ); ?>"><?php esc_html_e( 'Number of news items', '<%= theme %>' ); ?></label>
			<input
				class="tiny-text"
				id="<?php echo esc_attr( $this->get_field_id( 'widget_num' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'widget_num' ) ); ?>"
				type="number"
				value="<?php echo esc_attr( $widget_num ); ?>" />
		</p>

		<!-- Выпадающий список для выбора категории -->
		<p>
			<?php $categories = get_categories(); ?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php esc_html_e( 'Select the category', '<%= theme %>' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'post_category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>">
				<?php foreach ( $categories as $link_cat ) {
					echo '<option value="' . esc_attr( $link_cat->term_id ) . '" ' . selected( $post_category, $link_cat->term_id, false ) . '>' . esc_html( $link_cat->name ) . "</option>\n";
				} ?>
			</select>
		</p>

		<!-- Радио-кнопки для включения/выключения изображений -->
		<p>
			<label><?php esc_html_e( 'Show an Image', '<%= theme %>' ); ?></label><br>
			<input
				type="radio"
				id="<?php echo esc_attr( $this->get_field_id( 'widget_img_yes' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'widget_img' ) ); ?>"
				value="1"
				<?php checked( $widget_img, 1 ); ?>
			/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_img_yes' ) ); ?>"><?php esc_html_e( 'Yes', '<%= theme %>' ); ?></label>
			<br>
			<input
				type="radio"
				id="<?php echo esc_attr( $this->get_field_id( 'widget_img_no' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'widget_img' ) ); ?>"
				value="0"
				<?php checked( $widget_img, 0 ); ?>
			/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_img_no' ) ); ?>"><?php esc_html_e( 'No', '<%= theme %>' ); ?></label>
		</p>

		<?php
	} // Конец метода form

	/**
	 * Метод для отображения фронтенда виджета.
	 * Здесь выводится контент виджета на сайте.
	 *
	 * @param array $args Аргументы виджета.
	 * @param array $instance Настройки виджета.
	 */
	public function widget( $args, $instance ) {
		// Получение настроек виджета
		$title_widget   = isset( $instance['title_widget'] )  ? $instance['title_widget']  : '';
		$widget_num     = isset( $instance['widget_num'] )    ? $instance['widget_num']    : 5;
		$widget_img     = isset( $instance['widget_img'] )    ? $instance['widget_img']    : 1;
		$post_category  = isset( $instance['post_category'] ) ? $instance['post_category'] : 0;
  
		// Вывод начального HTML-кода виджета
		echo $args['before_widget'];
  
		// Вывод заголовка виджета
		echo $args['before_title'] . esc_html( $title_widget ) . $args['after_title'];
  
		// Создание запроса для получения последних новостей
		$query = new WP_Query( array(
			'orderby' => 'date',
			'cat' => $post_category,
			'posts_per_page' => $widget_num
		) );
  
		// Проверка наличия постов
		if ( $query->have_posts() ) : ?>
			<ul class="latestNews">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					// Проверка, находится ли пользователь на странице текущей новости
					$current_page_class = ( is_single() && get_the_ID() === get_queried_object_id() ) ? ' latestNews__title--current' : '';
					?>
					<li class="latestNews__item">
						<a class="latestNews__href" href="<?php the_permalink(); ?>">
							<?php if ( $widget_img == 1 ) : ?>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="latestNews__image">
										<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'latestNews__img' ) ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							<span class="latestNews__title<?php echo esc_attr( $current_page_class ); ?>"><?php the_title_attribute(); ?></span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif;
  
		// Вывод завершающего HTML-кода виджета
		echo $args['after_widget'];
  
		// Восстановление исходных данных запроса
		wp_reset_postdata();
	} // Конец метода widget

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
		$instance['title_widget']  = strip_tags( $new_instance['title_widget'] );
		$instance['widget_num']    = strip_tags( $new_instance['widget_num'] );
		$instance['widget_img']    = strip_tags( $new_instance['widget_img'] );
		$instance['post_category'] = strip_tags( $new_instance['post_category'] );

		return $instance;
	} // Конец метода update

} // Конец класса LatestNews

/**
 * Функция для регистрации виджета.
 * Эта функция вызывается при инициализации виджетов.
 */
if ( ! function_exists( '<%= theme %>_latest_news_load' ) ) {
	function <%= theme %>_latest_news_load() {
		register_widget( 'LatestNews' );
	}
}
add_action( 'widgets_init', '<%= theme %>_latest_news_load' );

?>