# Кастомизация Gutenberg

Эта папка содержит необходимые файлы и настройки для кастомизации редактора Gutenberg в теме WordPress. Кастомизация включает отключение/включение Gutenberg для записей и виджетов, изменение стандартных блоков Gutenberg и создание пользовательских блоков.

## Структура папки

```
gutenberg/
├── core/
│   ├── index.php
│   └── loginout/
│       └── loginout.php
├── custom-block/
│   └── index.php
└── gutenberg-setting.php
```

## Описание файлов

### `gutenberg-setting.php`

Этот файл содержит настройки для включения или отключения редактора Gutenberg для записей и виджетов. Он также подключает необходимые файлы для функциональности Gutenberg, если он включен.

- **`$block_editor_for_post`**: Установите значение `0`, чтобы отключить Gutenberg для редактирования записей, или `1`, чтобы включить.
- **`$widgets_block_editor`**: Установите значение `0`, чтобы отключить Gutenberg для редактирования виджетов, или `1`, чтобы включить.

В зависимости от этих настроек файл либо отключит Gutenberg, либо загрузит необходимые файлы для стандартных и пользовательских блоков.

### `core/index.php`

Этот файл является точкой входа для кастомизации стандартных блоков Gutenberg. В настоящее время он включает кастомизацию для блока `core/loginout`.

### `custom-block/index.php`

Этот файл является точкой входа для создания пользовательских блоков Gutenberg. В настоящее время он пуст, но может быть использован для подключения скриптов и функций, необходимых для создания пользовательских блоков.

## Как использовать

1. **Отключение/включение Gutenberg**:  
   Откройте файл `gutenberg-setting.php` и измените значения переменных `$block_editor_for_post` и `$widgets_block_editor` в зависимости от того, хотите ли вы отключить или включить Gutenberg для записей и виджетов.

2. **Кастомизация стандартных блоков**:  
   Для изменения стандартных блоков Gutenberg используйте папку `core/`, добавляя в неё новые папки имя которых соответствует имени блоку в который вы хотите внести изменения при мер блок `loginout` в папке `core/loginout`
   + Стандартные блоки находятся в папке `/wp-includes/blocks`. В этой папке, по имени блока, можно посмотреть какие параметры использует блок, доступ к параметрам можно получить используя массив `['attrs']` **например**: `$block['attrs']['displayLoginAsForm']` отвечает за показ формы входа в блоке `core/loginout`
   + Посмотреть имя стандартного блока можно в css классе(`wp-block-`) этого блока во фронтенде wordpress темы. например: `class="logged-out has-login-form wp-block-loginout" ` - это класс стандартного блока `loginout`.

3. **Создание пользовательских блоков**:  
   Для создания пользовательских блоков используйте папку `custom-block`