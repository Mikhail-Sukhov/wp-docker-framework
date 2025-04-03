<?php
/**
 * Файл с короткими кодами для форм и кнопок.
 *
 * Этот файл содержит функции для создания коротких кодов, которые используются для отображения форм и кнопок на сайте.
 *
 */

//-----------------------------------------------------------------------------------------------------//
// Формы
//-----------------------------------------------------------------------------------------------------//

/**
 * Короткий код для отображения скрытой формы заказа из каталога.
 *
 * @return string HTML-код формы.
 */
if ( ! function_exists( '<%= theme %>_getting_catalog_form_none' ) ) {
    function <%= theme %>_getting_catalog_form_none() {
        return get_catalog_form( "none" );
    }
}
add_shortcode( 'catalog_form_none', '<%= theme %>_getting_catalog_form_none' );

/**
 * Короткий код для отображения видимой формы заказа из каталога.
 *
 * @return string HTML-код формы.
 */
if ( ! function_exists( '<%= theme %>_getting_catalog_form' ) ) {
    function <%= theme %>_getting_catalog_form() {
        return get_catalog_form( "visible" );
    }
}
add_shortcode( 'catalog_form', '<%= theme %>_getting_catalog_form' );

//-----------------------------------------------------------------------------------------------------//
// Кнопки
//-----------------------------------------------------------------------------------------------------//

/**
 * Короткий код для отображения кнопки с формой заказа из каталога.
 *
 * @param array  $atts Атрибуты короткого кода.
 * @param string $shortcode_content Контент внутри короткого кода.
 * @return string HTML-код кнопки.
 */
if ( ! function_exists( '<%= theme %>_getting_button_catalog' ) ) {
    function <%= theme %>_getting_button_catalog( $atts, $shortcode_content = null ) {
        $atts = shortcode_atts(
            array(
                'get' => '',
            ),
            $atts
        );

        $b = $atts['get'];

        return '<a class="button__get js-var" data-vbtype="inline" data-get="' . esc_attr( $b ) . '" href="#form">' . do_shortcode( $shortcode_content ) . '</a>';
    }
}
add_shortcode( 'btn', '<%= theme %>_getting_button_catalog' );

?>