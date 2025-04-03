<?php
/**
 * Генерирует блок "липких" контактов с кнопками и формой заказа
 * 
 * Функция использует буферизацию вывода для формирования HTML-структуры.
 * Содержит кнопки для связи через различные мессенджеры и телефон.
 * 
 * @return string HTML-код блока контактов и связанных элементов
 * 
 */
if ( ! function_exists( 'get_sticky_contact' ) ) {
    function get_sticky_contact() {
        do_action( 'get_sticky_contact' );
        ob_start();
        ?>
        
        <?php echo get_catalog_form( 'none' ); ?>

        <div class="sticky-contact">
            <div class="sticky-contact__main-button" onclick="toggleFloatingButtons()">
                <span class="sticky-contact__icon icon-comment-empty"></span>
            </div>

            <div class="sticky-contact__buttons" id="floatingButtons">
                <a href="<?php echo esc_url( get_theme_mod( 'about_tel_1_href' ) ); ?>" 
                   target="_blank" 
                   class="sticky-contact__button"
                   rel="noopener noreferrer">
                     <span class="sticky-contact__icon icon-phone"></span>
                </a>
                
                <a href="#form" 
                   class="sticky-contact__button js-var" 
                   data-vbtype="inline">
                     <span class="sticky-contact__icon icon-at"></span>
                </a>
                
                <a href="<?php echo esc_url( get_theme_mod( 'about_wa' ) ); ?>" 
                   target="_blank" 
                   class="sticky-contact__button"
                   rel="noopener noreferrer">
                     <span class="sticky-contact__icon icon-whatsapp"></span>
                </a>
                
                <a href="<?php echo esc_url( get_theme_mod( 'about_tg' ) ); ?>" 
                   target="_blank" 
                   class="sticky-contact__button"
                   rel="noopener noreferrer">
                     <span class="sticky-contact__icon icon-paper-plane"></span>
                </a>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }
}

/**
 * Регистрирует и подключает скрипты для блока "липких" контактов
 * 
 * Функция добавляет JavaScript-файлы только для фронтенда.
 * Подключается через экшен 'get_sticky_contact'.
 *
 * @hook get_sticky_contact
 *
 * @return void
 * 
 */
function register_my_scripts_sticky_contact() {
    if ( ! is_admin() && ! is_user_admin() ) {
        wp_register_script(
            'sticky-contact-js',
            get_template_directory_uri() . '/inc/sticky-contact/sticky-contact.js',
            array(),
            wp_get_theme()->get( 'Version' ),
            true
        );

        wp_enqueue_script( 'sticky-contact-js' );
    }
}
add_action( 'get_sticky_contact', 'register_my_scripts_sticky_contact' );