<?php
/**
 * Template Name: landing
 * 
 * Шаблон лендинга.
 *
 * Этот файл отвечает за отображение лендинга.
 * Он подключает шапку, различные секции контента и подвал сайта.
 *
 */

get_template_part( 'head' ); // Подключаем head

echo '<body '; echo body_class( 'body body--landing' ); echo ' >';

wp_body_open(); // Открываем тег <body>

   echo '<section class="wrapper wrapper--landing">';

      // Контент шапки сайта
      get_template_part( 'header-content' );

      echo '<section class="content content--landing">';

         echo '<div class="content__row content__row--landing">';

            // Заказать продукт
            get_template_part( 'template-parts/get-product/get-product' );

            // Наши преимущества
            get_template_part( 'template-parts/b-advantage/b-advantage' );

            // Этапы
            // get_template_part( 'template-parts/stages/stages' );

            // Прайслист
            get_template_part( 'template-parts/price-list/price-list' );

            // О нас
            get_template_part( 'template-parts/b-about-us/b-about-us' );

            // Автопарк
            get_template_part( 'template-parts/transport/transport' );

            // Услуги на всю ширину
            get_template_part( 'template-parts/f-advantage/f-advantage' );

            // Документы
            get_template_part( 'template-parts/doc/doc' );

            // О нас  на всю ширину
            get_template_part( 'template-parts/f-about-us/f-about-us' );

            // Форма Заказа
            get_template_part( 'template-parts/get-form/get-form' );

            // Статьи
            get_template_part( 'template-parts/material/material' );

            // О Продукте
            get_template_part( 'template-parts/about-product/about-product' );

            // О всём продукте
            get_template_part( 'template-parts/excert-articles/excert-articles' );

            // Контакты
            get_template_part( 'template-parts/b-contact/b-contact' );

            // Контакты без карты на всю ширину
            get_template_part( 'template-parts/f-contact-text/f-contact-text' );

            // Контакты с картой на всю ширину
            get_template_part( 'template-parts/f-contact/f-contact' );

         echo '</div>';

      echo '</section>';

   echo '</section>';

/**
 * блок плавающих контактов
   * 
   */
echo get_sticky_contact();
   

wp_footer(); // Скрипты подвала


echo '</body>';

?>