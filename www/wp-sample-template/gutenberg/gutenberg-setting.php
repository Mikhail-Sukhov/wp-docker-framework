<?php
/**
 *
 * Этот файл содержит настройки для отключения Gutenberg в зависимости от условий.
 * Также подключает файлы настройки Gutenberg при необходимости.
 *
 */

/**
 * Отключаем Gutenberg для редактирования постов.
 *
 * 0 — отключить
 * 1 — включить
 */
$block_editor_for_post = 0;

/**
 * Отключаем Gutenberg для редактирования виджетов.
 *
 * 0 — отключить
 * 1 — включить
 */
$widgets_block_editor = 1;

// Настройки для постов Gutenberg
if ( ! $block_editor_for_post ) {
    /**
     * Отключаем Gutenberg для редактирования постов.
     */
    add_filter('use_block_editor_for_post', '__return_false', 10);
}

// Настройки для виджетов Gutenberg
if ( ! $widgets_block_editor ) {
    /**
     * Отключаем Gutenberg для редактирования виджетов.
     */
    add_filter('use_widgets_block_editor', '__return_false', 10);
} else {
    /**
     * Подключаем файл с функционалом Gutenberg для стандартных блоков.
     */
    require_once('core/index.php');

    /**
     * Подключаем файл с функционалом Gutenberg для кастомных блоков.
     */
    require_once('custom-block/index.php');
}

?>