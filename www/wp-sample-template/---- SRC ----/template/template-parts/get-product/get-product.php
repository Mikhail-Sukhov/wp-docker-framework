
<!-- Заказать продукт -->

<section class="content__item content__item--get-product wrap" data-sal="fade">

   <section class="get-product content__wrap">

      <?php
         $slugPriceArray = get_theme_mods()["priceArray"] ?: "Тестовый продукт 1\nТестовый продукт 2\nТестовый продукт 2";
         $slugsArray = explode("\n", $slugPriceArray );
         $n = 0;
         foreach($slugsArray as $i) {
         $n += 1;
      ?>

      <section class="get-product__cell">
         <figure class="get-product__figure">
            <img src="<?php echo get_theme_mod("price_image_{$i}", get_bloginfo('template_url')."/img/test-horizont-{$n}.jpg" ); ?>" alt="" class="get-product__img">
            <figcaption class="get-product__figcaption"><?php echo get_theme_mod("price_name_{$i}", "{$i}"); ?></figcaption>
         </figure>
         <div class="get-product__cont">
            <h3 class="get-product__price"><span class="b-price"><?php echo get_theme_mod("price_number_{$i}", "{$n}{$n}{$n}"); ?></span></h3>
            <p class="get-product__price-min"><?php echo get_theme_mod("price_textarea_{$i}", "Краткое описание позиции в price textarea: {$i}"); ?></p>
            <?php echo do_shortcode('[btn get="'.$i.'"]'.'Заказать'.'[/btn]'); ?>
            <a href="<?php echo home_url().get_theme_mod("price_url_{$i}", "{$i}"); ?>" class="get-product__readmore">Подробнее...</a>
         </div>
      </section>

      <?php }; ?>

   </section>

</section>
