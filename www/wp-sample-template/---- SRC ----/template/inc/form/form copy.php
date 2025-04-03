<?php
/**
 * Функция для отображения формы заказа.
 *
 * Эта функция генерирует HTML-код формы заказа.
 *
 * @param string $none Параметр для управления отображением формы.
 * @return void
 */
function get_catalog_form( $none ) {
    ?>

    <?php do_action( 'get_catalog_form' ); ?>

    <?php if ( $none == "none" ): ?>
    <section class="form" id="form">
        <section class="form__wrap" id="form__wrap" style="display: none">
    <?php else : ?>
    <section class="form" id="form">
        <section class="form__wrap" id="form__wrap">
    <?php endif; ?>

            <h2 class="form__title"><?php echo esc_html__( 'Order', '<%= theme %>' ); ?></h2>

            <form enctype="multipart/form-data" name="form__form" id="form__form" method="post">

                <div id="form__vars" class="form__vars"></div>

                <button class="form__close popup-modal-dismiss" type="button" name="button"></button>
                <section class="form__content">

                    <div class="form__row form__row--contact">

                        <div class="form__item form__item--name">
                            <div class="form__input-bg">
                                <span class="form__icon form__icon--name"></span>
                                <input
                                    type="text"
                                    class="form__input"
                                    id="form__name"
                                    name="form__name"
                                    placeholder="<?php echo esc_html__( 'Contact information(*)', '<%= theme %>' ); ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form__item form__item--email">
                            <div class="form__input-bg">
                                <span class="form__icon form__icon--email"></span>
                                <input
                                    type="email"
                                    class="form__input"
                                    id="form__email"
                                    name="form__email"
                                    placeholder="<?php echo esc_html__( 'Email(*)', '<%= theme %>' ); ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form__item form__item--tel">
                            <div class="form__input-bg">
                                <span class="form__icon form__icon--tel"></span>
                                <input
                                    type="tel"
                                    class="form__input"
                                    id="form__tel"
                                    name="form__tel"
                                    placeholder="<?php echo esc_html__( 'Phone number(*)', '<%= theme %>' ); ?>"
                                    required>
                            </div>
                        </div>

                    </div>

                    <div class="form__item form__item--textarea">
                        <textarea
                            class="form__textarea"
                            id="form__textarea"
                            name="form__textarea"
                            rows="3"
                            placeholder="<?php echo esc_html__( 'Comments on the order:', '<%= theme %>' ); ?>"></textarea>
                    </div>

                    <div class="form__row form__row--order">

                        <div class="form__item form__item--product">
                            <label class="form__label" for="form__product"><?php echo esc_html__( 'Product(*):', '<%= theme %>' ); ?></label>
                            <select id="form__product" class="js-input form__product form__select" name="form__product">
                                <option disabled selected="selected" data-price="0"><?php echo esc_html__( 'Select a product:', '<%= theme %>' ); ?></option>
                                <?php
                                $slugPriceArray = get_theme_mods()["priceArray"] ?? "";
                                $slugsArray = explode("\n", $slugPriceArray );
                                foreach($slugsArray as $i) {
                                ?>
                                    <option data-id="<?php echo $i; ?>" value="<?php echo get_theme_mod("price_name_{$i}", ""); ?> -- <?php echo get_theme_mod("price_number_{$i}", ""); ?>">
                                        <?php echo get_theme_mod("price_name_{$i}", ""); ?>
                                        <?php echo " -- " ?>
                                        <?php echo get_theme_mod("price_number_{$i}", ""); ?>
                                    </option>
                                <?php }; ?>
                            </select>
                        </div>

                        <div class="form__item form__item--quantity">
                            <label class="form__label" for="form__quantity"><?php echo esc_html__( 'Quantity(*):', '<%= theme %>' ); ?></label>
                            <div class="form__input-bg">
                                <button type="button" class="js-input form__step form__step--minus-10" onclick="this.nextElementSibling.nextElementSibling.stepDown(10)"></button>
                                <button type="button" class="js-input form__step form__step--minus" onclick="this.nextElementSibling.stepDown()"></button>
                                <input type="number"  min="1" value="1" class="js-input form__input form__quantity" id="form__quantity" name="form__quantity" required>
                                <button type="button" class="js-input form__step form__step--plus" onclick="this.previousElementSibling.stepUp()"></button>
                                <button type="button" class="js-input form__step form__step--plus-10" onclick="this.previousElementSibling.previousElementSibling.stepUp(10)"></button>
                            </div>
                        </div>

                    </div>

                    <div class="form__row form__row--price-all">

                        <div class="form__item form__item--price-all">
                            <label class="form__label form__label--price-all" for="form__price-all"><?php echo esc_html__( 'Total:', '<%= theme %>' ); ?></label>
                            <input
                                class="js-input form__input form__price-all"
                                readonly
                                type="text"
                                name="form__price_all"
                                id="form__price-all"
                                value="0">
                        </div>

                        <div class="form__item form__item--btn">
                            <input class="form__submit" id="form__submit" type="submit" hidden="hidden">
                            <label class="js-form__btn-submit form__btn-submit form__btn-submit--def" for="form__submit"><?php echo esc_html__( 'Get Order', '<%= theme %>' ); ?></label>
                        </div>

                    </div>

                </section>

            </form>

        </section>

    </section>

<?php };

/**
 * Функция для регистрации и подключения скриптов формы.
 *
 * Эта функция регистрирует и подключает скрипты, необходимые для работы формы.
 *
 * @return void
 */
function register_my_scripts_form() {
    if ( !is_admin() && !is_user_admin() ) {
        // регистрация скриптов
        wp_register_script( 'form-script-js', get_template_directory_uri() . '/inc/form/form-script.js', false, '', true );

        // подключение скриптов
        wp_enqueue_script( 'form-script-js' );
        wp_add_inline_script( 'form-script-js', 'const PATCHSENDMAIL = \''.get_template_directory_uri().'/inc/form/SendMail.php\';', 'before' );
    }
}
add_action( 'get_catalog_form', 'register_my_scripts_form' );

// Подключаем файл с шорткодами для отображения формы
require_once('form-shortcodes.php');

?>