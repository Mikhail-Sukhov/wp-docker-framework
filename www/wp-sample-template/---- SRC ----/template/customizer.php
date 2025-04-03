<?php 

if ( ! function_exists( '<%= theme %>_customizer_addition' ) ) {

function <%= theme %>_customizer_addition($wp_customize) {

   // Панели
   //-----------------------------------------------------------------------------------------------------//
   $wp_customize->add_panel( "theme_panel", array(
		"priority" => 1,
		"title" => esc_html__( 'Theme settings', '<%= theme %>' ),
		"description" => esc_html__( 'Theme settings', '<%= theme %>' ),
	));


	// Секция общие настройки
   //-----------------------------------------------------------------------------------------------------//
	$wp_customize->add_section("about_section", array(
	  "title" => esc_html__( 'General settings', '<%= theme %>' ),
	  "priority" => 5,
     "panel" => "theme_panel"
	));


   // Слоган
	$wp_customize->add_setting("about_slogan", array(
	  "capability" => "edit_theme_options",
	  "default" => "",
     "transport" => "postMessage",
	  "sanitize_callback" => "sanitize_text_field",
	));

	$wp_customize->add_control("about_slogan", array(
	  "type" => "input",
	  "section" => "about_section",
	  "label" => esc_html__( 'Slogan', '<%= theme %>' )." [about slogan]",
	));

   
   // Телефон 1
	$wp_customize->add_setting("about_tel_1", array(
	  "capability" => "edit_theme_options",
	  "default" => "",
     "transport" => "postMessage",
	  "sanitize_callback" => "sanitize_text_field",
	));

	$wp_customize->add_control("about_tel_1", array(
	  "type" => "input",
	  "section" => "about_section",
	  "label" => esc_html__( 'Phone number', '<%= theme %>' )." 1 [about tel_1]",
	));

   
   
   // Телефон 1(ссылка)
	$wp_customize->add_setting("about_tel_1_href", array(
      "capability" => "edit_theme_options",
      "default" => "tel:+7",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
	));
   
	$wp_customize->add_control("about_tel_1_href", array(
      "type" => "input",
      "section" => "about_section",
      "label" => esc_html__( 'Phone number href', '<%= theme %>' )." 1 [about tel_1_href]",
	));
   
   
   // Телефон 2
   $wp_customize->add_setting("about_tel_2", array(
      "capability" => "edit_theme_options",
      "default" => "",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
    ));
 
    $wp_customize->add_control("about_tel_2", array(
      "type" => "input",
      "section" => "about_section",
      "label" => esc_html__( 'Phone number', '<%= theme %>' )." 2 [about tel_2]",
    ));


   // Телефон 2(ссылка)
	$wp_customize->add_setting("about_tel_2_href", array(
      "capability" => "edit_theme_options",
      "default" => "tel:+7",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
	));
   
	$wp_customize->add_control("about_tel_2_href", array(
      "type" => "input",
      "section" => "about_section",
      "label" => esc_html__( 'Phone number href', '<%= theme %>' )." 2 [about tel_2_href]",
	));

   
   // Почта
	$wp_customize->add_setting("about_mail", array(
	  "capability" => "edit_theme_options",
	  "default" => "",
     "transport" => "postMessage",
	  "sanitize_callback" => "sanitize_text_field",
	));

	$wp_customize->add_control("about_mail", array(
	  "type" => "input",
	  "section" => "about_section",
	  "label" => esc_html__( 'Mail', '<%= theme %>' )." [about mail]",
	));

   
   // vk
	$wp_customize->add_setting("about_vk", array(
      "capability" => "edit_theme_options",
      "default" => "https://vk.com/",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
    ));
 
    $wp_customize->add_control("about_vk", array(
      "type" => "input",
      "section" => "about_section",
      "label" => "VK [about vk]",
    ));

   
   // tg
	$wp_customize->add_setting("about_tg", array(
      "capability" => "edit_theme_options",
      "default" => "https://t.me/",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
    ));
 
    $wp_customize->add_control("about_tg", array(
      "type" => "input",
      "section" => "about_section",
      "label" => "Telegram [about tg]",
    ));

   
   // wa
	$wp_customize->add_setting("about_wa", array(
      "capability" => "edit_theme_options",
      "default" => "https://wa.me/",
      "transport" => "postMessage",
      "sanitize_callback" => "sanitize_text_field",
    ));
 
    $wp_customize->add_control("about_wa", array(
      "type" => "input",
      "section" => "about_section",
      "label" => "WhatsApp [about wa]",
    ));

   
   // Адрес
	$wp_customize->add_setting("about_adress", array(
	  "capability" => "edit_theme_options",
	  "default" => "",
     "transport" => "postMessage",
	  "sanitize_callback" => "sanitize_text_field",
	));

	$wp_customize->add_control("about_adress", array(
	  "type" => "input",
	  "section" => "about_section",
	  "label" => esc_html__( 'Address', '<%= theme %>' )." [about address]",
	));

   
   // Скрипт адреса
   $wp_customize->add_setting("about_adress_script", array(
      "capability" => "edit_theme_options",
      "default" => "",
      "transport" => "postMessage",
   ));

   $wp_customize->add_control("about_adress_script", array(
      "type" => "textarea",
      "section" => "about_section",
      "label" => esc_html__( 'Address script', '<%= theme %>' )." [about address_script]",
   ));


   // Фирма
	$wp_customize->add_setting("about_firm", array(
	  "capability" => "edit_theme_options",
	  "default" => "",
     "transport" => "postMessage",
	  "sanitize_callback" => "sanitize_text_field",
	));

	$wp_customize->add_control("about_firm", array(
	  "type" => "input",
	  "section" => "about_section",
	  "label" => esc_html__( 'Firm', '<%= theme %>' )." [about firm]",
	));


   // Описание фирмы
   $wp_customize->add_setting("about_firm_text", array(
      "capability" => "edit_theme_options",
      "default" => "",
      "transport" => "postMessage",
   ));

   $wp_customize->add_control("about_firm_text", array(
      "type" => "textarea",
      "section" => "about_section",
      "label" => esc_html__( 'About firm', '<%= theme %>' )." [about firm_text]",
   ));


	// Секция Настройки главной страницы
   //-----------------------------------------------------------------------------------------------------//
	$wp_customize->add_section("home_page_section", array(
      "title" => esc_html__( 'Homepage Settings', '<%= theme %>' ),
      "priority" => 10,
      "panel" => "theme_panel"
   ));


	// Шаблон страницы
   $wp_customize->add_setting( "home_page_temp", array(
      "capability" => "edit_theme_options",
      "default" => "",
   ));

   $wp_customize->add_control( "home_page_temp", array(
      "section" => "home_page_section",
      "label" => esc_html__( 'Page Template', '<%= theme %>' ),
      "type" => "select",
      "choices" => [
         "" =>  esc_html__( 'Blog', '<%= theme %>' ),
         "table" =>  esc_html__( 'Table', '<%= theme %>' )
      ]
   ));


	// количество постов
	$wp_customize->add_setting("home_page_number", array(
	  "capability" => "edit_theme_options",
	  "default" => "5",
	  "sanitize_callback" => "sp_sanitize_number",
	));

	$wp_customize->add_control("home_page_number", array(
	  "type" => "number",
	  "section" => "home_page_section",
	  "label" => esc_html__( 'Number of posts', '<%= theme %>' ),
	));


   // Колонок в блоге	
   $wp_customize->add_setting( "home_page_col", array(
      "capability" => "edit_theme_options",
      "default" => "post--col-2",
   ));

   $wp_customize->add_control( "home_page_col", array(
      "section" => "home_page_section",
      "label" => esc_html__( 'Blog columns', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "post--col-1" => "1",
         "post--col-2" => "2",
         "post--col-3" => "3",
         "post--col-4" => "4"
      )
   ));


   // Секция Настройки страницы поиска
   //-----------------------------------------------------------------------------------------------------//
   $wp_customize->add_section("search_page_section", array(
      "title" => esc_html__( 'Search Page Settings', '<%= theme %>' ),
      "priority" => 15,
      "panel" => "theme_panel"
   ));


	// Шаблон страницы
   $wp_customize->add_setting( "search_page_temp", array(
      "capability" => "edit_theme_options",
      "default" => "",
   ));

   $wp_customize->add_control( "search_page_temp", array(
      "section" => "search_page_section",
      "label" => esc_html__( 'Page Template', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "" =>  esc_html__( 'Blog', '<%= theme %>' ),
         "table" =>  esc_html__( 'Table', '<%= theme %>' )
      )
   ));


	// количество постов
	$wp_customize->add_setting("search_page_number", array(
	  "capability" => "edit_theme_options",
	  "default" => "5",
	  "sanitize_callback" => "sp_sanitize_number",
	));

	$wp_customize->add_control("search_page_number", array(
	  "type" => "number",
	  "section" => "search_page_section",
	  "label" => esc_html__( 'Number of posts', '<%= theme %>' ),
	));


   // Колонок в блоге	
   $wp_customize->add_setting( "search_page_col", array(
      "capability" => "edit_theme_options",
      "default" => "post--col-2",
   ));

   $wp_customize->add_control( "search_page_col", array(
      "section" => "search_page_section",
      "label" => esc_html__( 'Blog columns', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "post--col-1" => "1",
         "post--col-2" => "2",
         "post--col-3" => "3",
         "post--col-4" => "4"
      )
   ));


   // Секция Настройки страницы категорий
   //-----------------------------------------------------------------------------------------------------//
   $wp_customize->add_section("category_page_section", array(
      "title" => esc_html__( 'Category Page Settings', '<%= theme %>' ),
      "priority" => 20,
      "panel" => "theme_panel"
   ));


	// Шаблон страницы
   $wp_customize->add_setting( "category_page_temp", array(
      "capability" => "edit_theme_options",
      "default" => "",
   ));

   $wp_customize->add_control( "category_page_temp", array(
      "section" => "category_page_section",
      "label" => esc_html__( 'Page Template', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "" => esc_html__( 'Blog', '<%= theme %>' ),
         "table" => esc_html__( 'Table', '<%= theme %>' )
      )
   ));


	// количество постов
	$wp_customize->add_setting("category_page_number", array(
	  "capability" => "edit_theme_options",
	  "default" => "5",
	  "sanitize_callback" => "sp_sanitize_number",
	));

	$wp_customize->add_control("category_page_number", array(
	  "type" => "number",
	  "section" => "category_page_section",
	  "label" => esc_html__( 'Number of posts', '<%= theme %>' ),
	));


   // Колонок в блоге	
   $wp_customize->add_setting( "category_page_col", array(
      "capability" => "edit_theme_options",
      "default" => "post--col-2",
   ));

   $wp_customize->add_control( "category_page_col", array(
      "section" => "category_page_section",
      "label" => esc_html__( 'Blog columns', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "post--col-1" => "1",
         "post--col-2" => "2",
         "post--col-3" => "3",
         "post--col-4" => "4"
      )
   ));


   // Секция Настройки страницы архивов
   //-----------------------------------------------------------------------------------------------------//
   $wp_customize->add_section("archive_page_section", array(
      "title" => esc_html__( 'Archive Page Settings', '<%= theme %>' ),
      "priority" => 25,
      "panel" => "theme_panel"
   ));


	// Шаблон страницы
   $wp_customize->add_setting( "archive_page_temp", array(
      "capability" => "edit_theme_options",
      "default" => "",
   ));

   $wp_customize->add_control( "archive_page_temp", array(
      "section" => "archive_page_section",
      "label" => esc_html__( 'Page Template', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "" =>  esc_html__( 'Blog', '<%= theme %>' ),
         "table" => esc_html__( 'Table', '<%= theme %>' )
      )
   ));


	// количество постов
	$wp_customize->add_setting("archive_page_number", array(
	  "capability" => "edit_theme_options",
	  "default" => "5",
	  "sanitize_callback" => "sp_sanitize_number",
	));

	$wp_customize->add_control("archive_page_number", array(
	  "type" => "number",
	  "section" => "archive_page_section",
	  "label" => esc_html__( 'Number of posts', '<%= theme %>' ),
	));


   // Колонок в блоге	
   $wp_customize->add_setting( "archive_page_col", array(
      "capability" => "edit_theme_options",
      "default" => "post--col-2",
   ));

   $wp_customize->add_control( "archive_page_col", array(
      "section" => "archive_page_section",
      "label" => esc_html__( 'Blog columns', '<%= theme %>' ),
      "type" => "select",
      "choices" => array(
         "post--col-1" => "1",
         "post--col-2" => "2",
         "post--col-3" => "3",
         "post--col-4" => "4"
      )
   ));


   // Секция Услуги
   // секция генерирует настройки по ключу
   // требуется перезагрузка страницы
   //-----------------------------------------------------------------------------------------------------//
   $wp_customize->add_section("price", array(
      "title" => esc_html__( 'Services', '<%= theme %>' ),
      "priority" => 25,
      "panel" => "theme_panel"
   ));


   // Массив услуг через textarea
	$wp_customize->add_setting("priceArray", array(
      "capability" => "edit_theme_options",
      "default" => "",
      "transport" => "postMessage",
      "sanitize_callback" => "wp_filter_nohtml_kses",
   ));
 
    $wp_customize->add_control("priceArray", array(
      "type" => "textarea",
      "section" => "price",
      "label" => esc_html__( 'Services labels', '<%= theme %>' ),
      "description" => esc_html__( 'Array of service labels', '<%= theme %>' )." [price price=slug]",
      // задавать через перенос строки(enter)
      // требуется перезагрузка страницы в браузере
      // услуги можно выводить в посты шорткодом: [price price=slug]
   ));


   // получаем все значения по ключу 'price_'
   if ( ! function_exists( 'getPriceKeys' ) ) {
      function getPriceKeys($array) {
         $keys = [];
         foreach ($array as $key => $value) {
            if (strpos($key, 'price_') === 0) {
               $keys[] = $key;
            }
         }
         return $keys;
      }
   }

   // получаем разницу между slug и имеющимися настройками
   if ( ! function_exists( 'filterKeysBySlugs' ) ) {
      function filterKeysBySlugs($keysArray, $slugsArray) {
         return array_filter($keysArray, function($key) use ($slugsArray) {
            foreach ($slugsArray as $slug) {
               if (strpos($key, $slug) !== false) {
                     return false;
               }
            }
            return true;
         });
      }
   }

   // получаем все значения настроек темы
   $inputArray = get_theme_mods() ?? "";

   // получаем все значения по ключу 'price_'
   $priceKeys = getPriceKeys($inputArray);

   // получаем массив slug
   $slugPriceArray = get_theme_mods()["priceArray"] ?? "";
   $slugsArray = explode("\n", $slugPriceArray );

   // получаем разницу между slug и имеющимися настройками
   $filteredKeys = filterKeysBySlugs($priceKeys, $slugsArray);


   // Удаляем настройки которых нет в массиве slug
   foreach($filteredKeys as $i) {
      remove_theme_mod( $i );
   }


   // Выводим настройки из массива slug
   foreach($slugsArray as $i) {

      // Название услуги
      $wp_customize->add_setting("price_name_{$i}", array(
         "capability" => "edit_theme_options",
         "default" => "",
         "transport" => "postMessage",
         "sanitize_callback" => "wp_filter_nohtml_kses",
      ));

      $wp_customize->add_control("price_name_{$i}", array(
         "type" => "input",
         "section" => "price",
         "label" => esc_html__( 'Name of the service', '<%= theme %>' )." [price_name get={$i}]",
      ));


      // Изображение услуги
      $wp_customize->add_setting("price_image_{$i}", array(
         "capability" => "edit_theme_options",
         "default" => "",
         "transport" => "postMessage",
         "sanitize_callback" => "esc_url_raw",
      ));
      
      $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "price_image_{$i}", array(
         "label" => esc_html__( 'Service image', '<%= theme %>' ),
         "section" => "price",
         "settings" => "price_image_{$i}",
      )));


      // ссылка услуги
      $wp_customize->add_setting("price_url_{$i}", array(
         "capability" => "edit_theme_options",
         "default" => "",
         "transport" => "postMessage",
         "sanitize_callback" => "esc_url_raw",
      ));

      $wp_customize->add_control("price_url_{$i}", array(
         "type" => "input",
         "section" => "price",
         "label" => esc_html__( 'Service href', '<%= theme %>' )." [price_url get={$i}]Some text[/price_url]",
      ));


      // Цена услуги
      $wp_customize->add_setting("price_number_{$i}", array(
         "capability" => "edit_theme_options",
         "default" => "",
         "transport" => "postMessage",
         "sanitize_callback" => "sp_sanitize_number",
      ));

      $wp_customize->add_control("price_number_{$i}", array(
         "type" => "number",
         "section" => "price",
         "label" => esc_html__( 'Price of services', '<%= theme %>' )." [price_num get={$i}]",
      ));


      // Описание услуги
      $wp_customize->add_setting("price_textarea_{$i}", array(
         "capability" => "edit_theme_options",
         "default" => "",
         "transport" => "postMessage",
         "sanitize_callback" => "wp_filter_nohtml_kses",
      ));
   
      $wp_customize->add_control("price_textarea_{$i}", array(
         "type" => "textarea",
         "section" => "price",
         "label" => esc_html__( 'Service description', '<%= theme %>' ),
      ));

   }


	// //checkbox
	// $wp_customize->add_setting("test_checkbox", array(
	// 	"capability" => "edit_theme_options",
	// 	"default" => "",
	// 	"sanitize_callback" => "sp_sanitize_checkbox",
	// ));

	// $wp_customize->add_control("test_checkbox", array(
	// 	"settings" => "test_checkbox",
	// 	"label"    => "checkbox",
	// 	"section"  => "test_section",
	// 	"type"     => "checkbox",
	// ));

	// //textarea
	// $wp_customize->add_setting("text_textarea", array(
	// 	"capability" => "edit_theme_options",
	// 	"default" => "",
	// 	"sanitize_callback" => "sp_sanitize_textarea",
	// ));

	// $wp_customize->add_control("text_textarea", array(
	// 	"type" => "textarea",
	// 	"section" => "test_section",
	// 	"label" => "Textarea",
	// ));

	// //image
	// $wp_customize->add_setting("test_img", array(
	// 	"capability"        => "edit_theme_options",
	// 	"sanitize_callback" => "esc_url_raw",
	// 	"default" => "",
	// ));

	// $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, "test_img", array(
	// 	"label"    => "Image",
	// 	"section"  => "test_section",
	// 	"settings" => "test_img",
	// )));

}

}
add_action("customize_register", "<%= theme %>_customizer_addition");


//sanitize checkbox
if ( ! function_exists( 'sp_sanitize_checkbox' ) ) {
   function sp_sanitize_checkbox($input) {
      if ($input == 1) return 1;
      else return "";   
   }
}

//sanitize textarea
if ( ! function_exists( 'sp_sanitize_textarea' ) ) {
   function sp_sanitize_textarea($input){
      return wp_kses_post($input);
   }
}

//sanitize number
if ( ! function_exists( 'sp_sanitize_number' ) ) {
   function sp_sanitize_number($input){
      return intval($input);
   }
}




