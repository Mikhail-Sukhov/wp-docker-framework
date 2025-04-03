# Папка `extra-function`

Папка `extra-function` содержит дополнительные функции и утилиты, которые могут быть использованы в различных частях проекта. Эти функции помогают в обработке данных, преобразовании единиц измерения и других задачах. Ниже приведены описания и примеры использования каждого файла в этой папке.

## Содержание

1. [Файл `map-replacement.scss`](#файл-map-replacementscss)
2. [Файл `px-to-rem.scss`](#файл-px-to-remscss)
3. [Файл `str-split.scss`](#файл-str-splittingscss)
4. [Файл `str-map.scss`](#файл-str-mapscss)
5. [Файл `to-number.scss`](#файл-to-numberscss)
6. [Файл `to-unit.scss`](#файл-to-unitscss)
7. [Файл `index.scss`](#файл-indexscss)

---

### Файл `map-replacement.scss`

**Описание:**
Файл `map-replacement.scss` содержит карту для замены значений. Эта карта используется в `str-map.scss` для замены значений.

**Пример:**
```scss
$map-replacement: (
   'custom': 10px,
   'gap': $gap
);
```

---

### Файл `px-to-rem.scss`

**Описание:**
Функция `px-to-rem` преобразует пиксели в rem.

**Пример:**
```scss
.element {
   font-size: px-to-rem(16px); // Возвращает 1rem
}
```

---

### Файл `str-split.scss`

**Описание:**
Функция `str-split` разделяет строку на части по заданному разделителю.

**Пример:**
```scss
$result: str-split("hello-world", "-");
// $result: ("hello", "world");
```

---

### Файл `str-map.scss`

**Описание:**
Функция `str-map` преобразует строку в карту согласно брейкпойнтам. Преобразует строковое значение например: `l-b-50 m-s-20` в карту (l-b: 50px, m-s-20px). Необходимо для работы миксинов в папке `breakpoints` 

**Пример:**
```scss
$result: str-map("l-custom_x2 b-custom_d3 m-s-50");
// $result: (l: 20px, b: 5px, m-s: 50px);
```

---

### Файл `to-number.scss`

**Описание:**
Функция `to-number` преобразует строку в число.

**Пример:**
```scss
$result: to-number('123'); // Возвращает 123
$result: to-number('-45.67'); // Возвращает -45.67
```

---

### Файл `to-unit.scss`

**Описание:**
Функция `to-unit` преобразует значения в указанную единицу измерения.

**Пример:**
```scss
$list: 10, 20px, 30, 40em;
$result-list: to-unit.to-unit($list, 'px'); // Вывод: 10px, 20px, 30px, 40em

$string: '50';
$result-string: to-unit.to-unit($string, 'rem'); // Вывод: 50rem
```

---

### Файл `index.scss`

**Описание:**
Файл `index.scss` является индексным файлом, который импортирует все необходимые файлы из папки `extra-function`. Этот файл служит точкой входа для всех утилит и функций, используемых в папке.


