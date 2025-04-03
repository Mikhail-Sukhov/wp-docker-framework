
<?php /* Template Name: Контакты */ ?>

<!-- Контакты -->

<section class="content__item content__item--contact wrap" data-sal="fade">

   <section class="contact">

      <section class="contact__cell contact__cell--map">
         <?php echo get_theme_mod("about_adress_script", '<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad6425ba62e03c724c6f62236736e55166288b9752d149e9536a871de87a26415&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>'); ?>
      </section>

      <section class="contact__cell contact__cell--txt">
         <h3 class="contact__titles">Контакты:</h3>
         <p class="contact__txt contact__txt--tel"><?php echo get_theme_mod("about_tel_1", "8 (123)456-78-90"); ?></p>
         <p class="contact__txt contact__txt--tel"><?php echo get_theme_mod("about_tel_2", "8 (098)765-43-21"); ?></p>
         <p class="contact__txt contact__txt--mail"><?php echo get_theme_mod("about_mail", "pochta@pochta.loc"); ?></p>
         <h4 class="contact__titles-min">Офис:</h4>
         <p class="contact__txt contact__txt--adress-office"><?php echo get_theme_mod("about_adress", "Адрес"); ?></p>
      </section>

   </section>

</section>