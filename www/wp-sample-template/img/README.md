
# Изображения

Эта папка содержит все изображения, используемые в проекте. Изображения оптимизируются при сборке с помощью плагина [gulp-image](https://www.npmjs.com/package/gulp-image). 

## Структура

Папка `img` организована следующим образом:
```
img/
├── 404.jpg # Изображение для страницы 404 в WordPress
├── logo.png # Логотип по умолчанию для темы WordPress
├── svg/ # SVG-изображения
│   ├── color/ # Цветные SVG, не требующие обработки
│   └── mono/  # Монохромные SVG, которые можно стилизовать через CSS
├── favicon/   # Иконки favicon
```
## Правила использования

### Оптимизация изображений

Все изображения автоматически оптимизируются при сборке проекта с помощью плагина [gulp-image](https://www.npmjs.com/package/gulp-image). Убедитесь, что изображения добавлены в папку `img` до запуска сборки.

### Именование файлов

Избегайте одинаковых названий у изображений, так как это может привести к конфликтам при использовании плагина [postcss-assets](https://www.npmjs.com/package/postcss-assets).

### favicon
favicon сгенерирован через [realfavicongenerator](https://realfavicongenerator.net)

### SVG-изображения

SVG-изображения разделены на две категории:
- **color**: Цветные SVG, которые не требуют дополнительной обработки.
- **mono**: Монохромные SVG, которые можно стилизовать через CSS-свойство `fill`.

При сборке все SVG объединяются в два спрайта:
- `svg--color` (для цветных SVG)
- `svg--mono` (для монохромных SVG)

### Использование SVG-спрайтов в WordPress

Для использования SVG-спрайтов в шаблонах WordPress:

#### Монохромный спрайт
```html
<svg class="">
   <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/mono--sprite.svg#wordpress"></use>
</svg>
```
#### Цветной спрайт
```html
<svg class="">
   <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/color--sprite.svg#wordpress"></use>
</svg>
```

