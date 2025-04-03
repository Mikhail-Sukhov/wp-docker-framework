# Папка `breakpoints`

Папка `breakpoints` предоставляет мощные инструменты для управления медиа-запросами и создания адаптивного дизайна. Миксин `res` является одним из ключевых элементов этой папки, позволяя гибко и удобно применять стили на основе брейкпоинтов.

## Содержание

1. [Файл `breakpoints.scss`](#файл-breakpointscss)
2. [Файл `respond.scss`](#файл-respondscss)
3. [Файл `res.scss`](#файл-resscss)
4. [Файл `index.scss`](#файл-indexscss)

---

### Файл `breakpoints.scss`

**Описание:**
Файл `breakpoints.scss` содержит логику для определения и использования брейкпоинтов. Он предоставляет миксин `breakpoints`, который генерирует медиа-запросы на основе брейкпоинтов.

**Пример:**
```scss
@use 'breakpoints';

.example {
   @include breakpoints(l-b) {
      color: red;
   }
   @include breakpoints(min-1000px) {
      color: blue;
   }
}
```

**Зависимости:**
- Функция `respond` из файла `respond.scss`
- Функция `respond-next` из файла `breakpoints.scss`
- Функция `to-number` из папки `extra-function`

---

### Файл `respond.scss`

**Описание:**
Файл `respond.scss` содержит карту брейкпоинтов и функцию `respond` для извлечения значений из этой карты. Эта функция используется в других файлах для получения значений брейкпоинтов.

**Пример:**
```scss
$breakpoint: respond('b'); // Возвращает 1200px
```

**Зависимости:**
- Функция `to-number` из папки `extra-function`

---

### Файл `res.scss`

**Описание:**
Файл `res.scss` содержит миксин `res`, который является одним из основных в проекте. Этот миксин позволяет применять стили на основе брейкпоинтов. Он поддерживает различные форматы входных данных.

**Примеры:**

1. **Применение стилей на основе карты брейкпоинтов:**
   ```scss

   @include res(padding, (l: 10px, m: 20px, s: 30px));
   ```

2. **Применение стилей на основе строки:**
   ```scss
   @include res(padding l-10px m-20px s-30px);
   @include res(padding, l-10px m-20px s-30px);
   @include res("padding l-10px m-20px s-30px");
   ```

3. **Применение стилей на основе нескольких свойств:**
   ```scss
   @include res(
      padding l-10px m-20px s-30px /
      margin l-10px m-20px s-30px /
      font-size l-b-22px m-s-10px
   );
   ```

**Зависимости:**
- Миксин `breakpoints` из файла `breakpoints.scss`
- Функция `str-split` из папки `extra-function`
- Функция `str-map` из папки `extra-function`
- Функция `to-unit` из папки `extra-function`

---

### Файл `index.scss`

**Описание:**
Файл `index.scss` является индексным файлом, который импортирует все необходимые файлы из папки `breakpoints`. Этот файл служит точкой входа для всех утилит и функций, используемых в папке.
