<?php
/**
 * Функция для отображения формы входа и меню пользователя.
 *
 * Эта функция проверяет, авторизован ли пользователь, и в зависимости от этого
 * отображает либо меню пользователя, либо форму входа.
 *
 */

if ( ! function_exists( 'get_s_login' ) ) {
    function get_s_login() {
        ob_start();
        if ( is_user_logged_in() ) : // Проверка, авторизован ли пользователь ?>
            <ul class="s-login__menu">
                <li class="s-login__item">
                    <a class="s-login__href s-login__href--post-new" href="<?php echo esc_url( home_url() ); ?>/wp-admin/post-new.php"><?php echo esc_html__( 'Get Post', '<%= theme %>' ); ?></a>
                </li>
                <li class="s-login__item">
                    <a class="s-login__href s-login__href--profile" href="<?php echo esc_url( home_url() ); ?>/wp-admin/profile.php"><?php echo esc_html__( 'Profile', '<%= theme %>' ); ?></a>
                </li>
                <li class="s-login__item">
                    <a class="s-login__href s-login__href--out" href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"><?php echo esc_html__( 'Out', '<%= theme %>' ); ?></a>
                </li>
            </ul>
        <?php else : // Если не авторизован?>
            <div class="s-login">
                <form class="s-login__form" name="loginform" action="<?php echo esc_url( home_url() ); ?>/wp-login.php" method="post">
                    <div class="s-login__log">
                        <label class="s-login__icon-log" for="log"></label>
                        <input class="s-login__input" type="text" id="log" name="log" placeholder="<?php echo esc_html__( 'Login', '<%= theme %>' ); ?>" />
                    </div>
                    <div class="s-login__pwd">
                        <label class="s-login__icon-pwd" for="pwd"></label>
                        <input class="s-login__input" type="password" id="pwd" name="pwd" placeholder="<?php echo esc_html__( 'Password', '<%= theme %>' ); ?>" />
                    </div>
                    <input type="hidden" name="rememberme" value="forever" />
                    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>"/>
                    <button class="s-login__submit" type="submit" name="submit"><?php echo esc_html__( 'Log in', '<%= theme %>' ); ?></button>
                </form>
                <?php if ( get_option( 'users_can_register' ) ) : // Доступна ли регистрация новых пользователей ?>
                    <a class="s-login__advenced" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php echo esc_html__( 'Forgot your password?', '<%= theme %>' ); ?></a>
                    <a class="s-login__advenced" href="<?php echo esc_url( wp_registration_url() ); ?>"><?php echo esc_html__( 'Registration', '<%= theme %>' ); ?></a>
                <?php endif; ?>
            </div>
        <?php endif;
        return ob_get_clean();
    }
}
?>