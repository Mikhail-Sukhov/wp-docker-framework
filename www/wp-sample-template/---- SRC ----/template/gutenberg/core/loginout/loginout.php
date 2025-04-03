<?php
/**
 * Функция для модификации блока входа/выхода.
 *
 * @param string $block_content Содержимое блока.
 * @param array  $block         Данные блока.
 * @return string               Модифицированное содержимое блока.
 * 
 */
if ( ! function_exists( '<%= theme %>_custom_modify_render_block_core_loginout' ) ) {
   function <%= theme %>_custom_modify_render_block_core_loginout($block_content, $block) {

      $classes  = is_user_logged_in() ? 'logged-in' : 'logged-out';

      // Изменяем содержимое блока
      if ( ! empty( $block['attrs']['displayLoginAsForm'] ) ) {
         $classes .= ' has-login-form';

         // Используем пользовательскую функцию для отображения формы входа
         $block_content = get_s_login();
      }

      $wrapper_attributes = implode(' ', array( 'class' => $classes ) );

      return '<div class="' . $wrapper_attributes . '">' . $block_content . '</div>';
   }
}

// Добавляем фильтр для изменения содержимого блока
add_filter('render_block_core/loginout', '<%= theme %>_custom_modify_render_block_core_loginout', 10, 2);

?>