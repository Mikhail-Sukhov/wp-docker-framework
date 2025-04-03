# Gulpfile для сборки WordPress тем

Этот Gulpfile предназначен для автоматизации сборки WordPress тем. Он включает задачи для обработки изображений, шрифтов, SCSS, JavaScript, HTML/PHP файлов и многое другое.

## Содержание

- [Использование](#использование)
- [Задачи](#задачи)
  - [Обработка изображений](#обработка-изображений)
  - [Обработка шрифтов](#обработка-шрифтов)
  - [Обработка библиотек](#обработка-библиотек)
  - [Обработка SCSS](#обработка-scss)
  - [Обработка шаблонов](#обработка-шаблонов)
  - [Обработка JavaScript](#обработка-javascript)
  - [Обработка SVG](#обработка-svg)
  - [BrowserSync](#browsersync)
  - [Наблюдение за изменениями](#наблюдение-за-изменениями)
  - [Очистка папки сборки](#очистка-папки-сборки)
  - [Переключение режима сборки](#переключение-режима-сборки)
- [Составные задачи](#составные-задачи)
  - [Стартовый таск](#стартовый-таск)
  - [Рабочий таск](#рабочий-таск)
  - [Финальный таск](#финальный-таск)

## Использование

### Основные команды

- **Запуск разработки**:

  ```bash
  gulp start
  gulp work
  ```

- **Финальная сборка**:

  ```bash
  gulp end
  ```

- **Очистка папки сборки**:

  ```bash
  gulp del
  ```

## Задачи

### Обработка изображений

**Описание**: Минифицирует изображения и переносит их в папку сборки.
Минификация изображений работает во время `gulp end` во время рабочего(`gulp work`) и стартового(`gulp start`) таска изображения просто переносятся в папку сборки. это нужно для экономии времени в процессе разработки т.к. минифмкация большого количества изображений может занимать до нескольких минут времени.

**Исходный путь**: `img/**/*`

**Папка сборки**: `img`

**Плагины**:
- [`gulp-image`](https://www.npmjs.com/package/gulp-image): Оптимизация изображений.

**Пример выполнения**:

```bash
gulp imagesTask
```

**Код**:

```javascript
export const images = {
   src: [`${dir.src}img/**/*`, `!${dir.src}img/svg/**/*`],
   watch: `${dir.src}img/**/*`,
   build: `${dir.build}img`,
   config: {
      pngquant: true, // Включить оптимизацию PNG с помощью pngquant
      optipng: false, // Отключить optipng (если используется pngquant)
      zopflipng: false, // Отключить zopflipng
      jpegRecompress: false, // Отключить jpeg-recompress (используем mozjpeg)
      mozjpeg: true, // Включить оптимизацию JPEG с помощью mozjpeg
      gifsicle: true, // Включить оптимизацию GIF
      svgo: false, // Отключить оптимизацию SVG (если не нужно)
      concurrent: 4, // Количество параллельных процессов
   }
};

export function imagesTask() {
   return src(images.src, { encoding: false })
      .pipe(newer(images.build))
      .pipe(
         plumber({
            errorHandler: notify.onError(
               'Error imagesTask(): <%= error.message %>'
            ),
         })
      )
      .pipe(gulpif(!isDevelopment, gulpImage(images.config)))
      .pipe(size())
      .pipe(dest(images.build));
}
```

### Обработка шрифтов

**Описание**: Копирует шрифты в папку сборки.

**Исходный путь**: `font/**/*.{otf,ttf,woff,woff2,eot,svg}`

**Папка сборки**: `font`

**Пример выполнения**:

```bash
gulp fontTask
```

**Код**:

```javascript
export const font = {
   src: `${dir.src}font/**/*.{otf,ttf,woff,woff2,eot,svg}`,
   build: `${dir.build}font`,
};

export function fontTask() {
   return src(font.src, { encoding: false })
      .pipe(newer(font.build))
      .pipe(
         plumber({
            errorHandler: notify.onError(
               'Error fontTask(): <%= error.message %>'
            ),
         })
      )
      .pipe(size())
      .pipe(dest(font.build));
}
```

### Обработка библиотек

**Описание**: Включает в себя несколько задач для обработки библиотек:

- **`libsPackages`**: Копирует зависимости(dependencies - библиотеки необходимые для функционирования проекта) из `node_modules` в папку `libs`.
- **`libsTech`**: Копирует файлы из папки `tech-theme-files` в корневую папку сборки.
- **`libsJquery`**: Копирует jQuery в папку `libs`.
	- По умолчанию jQuery никак не задействован в шаблоне WordPress, но бывают ситуации когда актуальная версия jQuery необходима, он будет в папке `libs`.
- **`libsFiles`**: Копирует шрифты и изображения из библиотек в папку `libs`.

**Пример выполнения**:

```bash
gulp libsAllTask
```

**Код**:

```javascript
export const libs = {
   js: {
      jquery: [
         `${dir.src}libs/**/**/jquery/**/jquery.min.js`,
         `${dir.src}libs/**/**/jquery-migrate/**/jquery-migrate.min.js`,
      ],

      build: `${dir.build}libs`,
   },

   files: {
      src: [
         `${dir.src}libs/**/*.{png,jpg,jpeg,gif,svg,bmp,webp}`,
         `${dir.src}libs/**/*.{otf,ttf,woff,woff2,eot}`,
      ],

      build: `${dir.build}libs`,
   },

   tech: {
      src: [
         `${dir.src}tech-theme-files/**/*`,
         `!${dir.src}tech-theme-files/README.md`,
      ],
      build: `${dir.build}`,
   },

   // Извлекает dependencies из package.json
   moduleFiles: () => {
      let modules = Object.keys(packageJson.dependencies);
      let moduleFiles = modules.map((module) => {
         return dir.src + 'node_modules/' + module + '/**/*.*';
      });
      return moduleFiles;
   },
};

// переносит dependencies из package.json
export function libsPackages() {
   return src(libs.moduleFiles(), { base: dir.src + 'node_modules', encoding: false })
      .pipe(newer('libs'))
      .pipe(
         plumber({
            errorHandler: notify.onError('<%= error.message %>'),
         })
      )
      .pipe(dest( dir.src + 'libs' ));
}

// переносит все из tech-theme-files в build
export function libsTech() {
   return src(libs.tech.src, { encoding: false })
      .pipe(newer(libs.tech.build))
      .pipe(
         plumber({
            errorHandler: notify.onError('<%= error.message %>'),
         })
      )
      .pipe(dest(libs.tech.build));
}

// переносит jquery
export function libsJquery() {
   return src(libs.js.jquery)
      .pipe(newer(libs.js.build))
      .pipe(rename({ dirname: '' }))
      .pipe(dest(libs.js.build));
}

// обрабатывает шрифты и изображения из dependencies
export function libsFiles() {
   return src(libs.files.src, { encoding: false })
      .pipe(newer(libs.files.build))
      .pipe(
         plumber({
            errorHandler: notify.onError('<%= error.message %>'),
         })
      )
      .pipe(dest(libs.files.build));
}

export const libsAllTask = series(
   libsPackages,
   parallel(libsFiles, libsTech, libsJquery)
);
```

### Копирование index.html во все подпапки

**Описание**: Копирует файл `index.html` во все подпапки папки сборки.
Создание пустого `index.html` в каждой папке темы WordPress предотвращает просмотр содержимого папки через браузер, если в ней нет индексного файла. Это мера безопасности, которая защищает от листинга директорий и скрывает структуру файлов от посторонних.

**Пример выполнения**:

```bash
gulp copyIndex
```

**Код**:

```javascript
export async function copyIndex() {
   const sourceFile = path.join(dir.src, 'tech-theme-files/index.html');
   const targetDir = dir.build;

   // Проверяем, существует ли исходный файл
   if (!fs.existsSync(sourceFile)) {
      console.error(`Файл ${sourceFile} не существует.`);
      return;
   }

   // Получаем все подпапки (включая вложенные) в целевой директории
   const subfolders = getSubfoldersRecursive(targetDir);

   // Копируем файл во все подпапки через цикл
   for (const folder of subfolders) {
      await new Promise((resolve, reject) => {
         src(sourceFile)
            .pipe(plumber({
               errorHandler: notify.onError('Error copyIndexToSubfolders(): <%= error.message %>'),
            }))
            .pipe(dest(folder))
            .on('end', resolve)
            .on('error', reject);
      });
   }
}
```

### Получение всех подпапок рекурсивно

**Описание**: Рекурсивно получает все подпапки в целевой директории.

**Код**:

```javascript
function getSubfoldersRecursive(dir) {
   let subfolders = [];

   // Проверяем, существует ли директория
   if (!fs.existsSync(dir)) {
      console.error(`Директория ${dir} не существует.`);
      return subfolders;
   }

   // Рекурсивно обходим все папки
   function walk(folder) {
      try {
         const files = fs.readdirSync(folder);
         files.forEach(file => {
            const filePath = path.join(folder, file);
            if (fs.statSync(filePath).isDirectory()) {
               // Исключаем папку "---- SRC ----"
               if (file !== '---- SRC ----') {
                  subfolders.push(filePath); // Добавляем папку в список
                  walk(filePath); // Рекурсивно обходим вложенные папки
               }
            }
         });
      } catch (error) {
         console.error(`Ошибка при обходе папки ${folder}:`, error);
      }
   }

   walk(dir); // Начинаем обход с корневой папки
   return subfolders;
}
```

### Обработка SCSS

**Описание**: Компилирует SCSS в CSS, добавляет вендорные префиксы, минифицирует CSS и переносит его в папку сборки.

**Исходный путь**: `scss/**/*.scss`, `template/**/*.scss`

**Папка сборки**: `css`

**Плагины**:
- [`gulp-sass`](https://www.npmjs.com/package/gulp-sass): Компиляция SCSS в CSS.
- [`gulp-postcss`](https://www.npmjs.com/package/gulp-postcss): Применение PostCSS плагинов.
- [`autoprefixer`](https://www.npmjs.com/package/autoprefixer): Добавление вендорных префиксов.
- [`cssnano`](https://www.npmjs.com/package/cssnano): Минификация CSS.
- [`postcss-assets`](https://www.npmjs.com/package/postcss-assets): Обработка ресурсов в CSS.
- [`postcss-pxtorem`](https://www.npmjs.com/package/postcss-pxtorem): Конвертация px в rem.
- [`postcss-import`](https://www.npmjs.com/package/postcss-import): Импорт CSS файлов.
- [`postcss-sort-media-queries`](https://www.npmjs.com/package/postcss-sort-media-queries): Сортировка медиа-запросов.
- [`postcss-merge-rules`](https://www.npmjs.com/package/postcss-merge-rules): Объединение одинаковых CSS правил.

**Пример выполнения**:

```bash
gulp scssTask
```

**Код**:

```javascript
export const scss = {
   src: [
      `${dir.src}scss/**/*.scss`,
      `!${dir.src}scss/**/__**.scss`,
      `${dir.src}template/**/*.scss`,
      `!${dir.src}template/**/__**.scss`,
   ],
   watch: [`${dir.src}scss/**/*.scss`, `${dir.src}template/**/*.scss`],
   build: `${dir.build}css`,

   // Вставка изображений
   processorsAssets: [
      assets({
         loadPaths: [
            'img/**',
            'font/**',
            'libs/**',
         ],
         cachebuster: true,
         basePath: '../',
         baseUrl: '../',
      }),
   ],

   // Настройки postcss pxtorem
   pxtorem: [
      pxtorem({
         rootValue: 16, // Исходный размер
         propList: ['*'], // Свойства подверженные изменениям
         unitPrecision: 3, // Количество символов после запятой
         replace: false, // Фалбеки(px)/По умолчанию(нет)(true)/если нужны(false)
         minPixelValue: 2, // Минимальный размер px для изменений
         selectorBlackList: ['.wrap', 'html'], // селекторы которые игнорируются
         mediaQuery: false, // запрет на изменение mediaQuery
      }),
   ],

   // Настройки postcss
   processors: [
      cssMerge(),
      sortMediaQueries(),
      autoprefixer({ overrideBrowserslist: ['last 4 version', 'ie >= 11'] }),
      cssnano(),
   ],

   // функция замены "url(" на "resolve(" в css потоке, для работы postCss-assets
   mapReplace: (file, done) => {
      file.contents = new Buffer.from(
         file.contents.toString().replace(/url\(/g, 'resolve(')
      );
      return done(null, file);
   },
};

export function scssTask() {
   return (
      src(scss.src)
         .pipe(
            plumber({
               errorHandler: notify.onError(
                  'Error scssTask(): <%= error.message %>'
               ),
            })
         )
         .pipe(gulpif(isDevelopment, sourcemaps.init()))
         .pipe(
            sass.sync({ outputStyle: 'compressed' }).on('error', sass.logError)
         )
         .pipe(postcss([postcssImport]))
         .pipe(map(scss.mapReplace))
         .pipe(postcss(scss.processorsAssets))
         .pipe(postcss(scss.pxtorem))
         .pipe(gulpif(!isDevelopment, postcss(scss.processors)))
         .pipe(gulpif(isDevelopment, sourcemaps.write()))
         .pipe(rename({ dirname: '' }))
         .pipe(size())
         .pipe(dest(scss.build))
         .pipe(browserSync.stream())
   );
}

export const scssAllTask = series(
   parallel(fontTask, imagesAllTask, libsAllTask),
   scssTask
);
```

### Обработка шаблонов

**Описание**: Копирует HTML/PHP файлы в папку сборки, заменяет шаблоны и добавляет кэш-брейки.

**Исходный путь**: `template/**/*.{html,php,js}`

**Папка сборки**: `../`

**Плагины**:
- [`gulp-template`](https://www.npmjs.com/package/gulp-template): Замена шаблонов.
- [`gulp-cache-bust`](https://www.npmjs.com/package/gulp-cache-bust): Добавление кэш-брейков.
- [`gulp-remove-html-comments`](https://www.npmjs.com/package/gulp-remove-html-comments): Удаление HTML комментариев.

**Пример выполнения**:

```bash
gulp templateTask
```

**Код**:

```javascript
export const template = {
   src: `${dir.src}template/**/*.{html,php,js}`,
   watch: `${dir.src}template/**/*.{html,php,js}`,
   build: dir.build,
};

export function templateTask() {
   return src(template.src)
      .pipe(
         plumber({
            errorHandler: notify.onError(
               'Error templateTask(): <%= error.message %>'
            ),
         })
      )
      .pipe(newer(template.build))
      .pipe(gulpTemplate({ theme: themeFolderName })) // заменяет <%= theme %> на путь к папке шаблона WP
      .pipe(gulpif(!isDevelopment, cachebust({ type: 'timestamp' })))
      .pipe(gulpif(!isDevelopment, remHtmlComm()))
      .pipe(size())
      .pipe(dest(template.build));
}
```

**Примечание**: 
- **Кэш-брейк** — это техника, которая добавляет уникальный идентификатор (например, временную метку) к URL ресурсов (CSS, JS, изображений и т.д.), чтобы браузеры не использовали кэшированные версии файлов после их обновления. Это особенно полезно при разработке, чтобы изменения сразу отображались без необходимости очистки кэша браузера.
- Переменная `themeFolderName` используется для замены шаблонов в HTML/PHP файлах. Она извлекается из текущей рабочей директории. В частности, она берется из названия папки, которая находится перед папкой `---- SRC ----`. Например, если структура папок выглядит так:

**Код получения переменной `themeFolderName`**:

```javascript
// Получаем текущую рабочую директорию
const currentDir = process.cwd();

// Разбиваем путь на части
const pathParts = currentDir.split(path.sep);

// Получаем название папки, которая находится перед "SRC"
let themeFolderName = pathParts[pathParts.length - 3];

// Удаляем все символы, кроме текста и цифр
themeFolderName = themeFolderName.replace(/[^a-zA-Z0-9]/g, '');

// Выводим название папки в консоль для проверки
console.log('Theme folder name:', themeFolderName);
```

### Обработка JavaScript

**Описание**: Компилирует и минифицирует JavaScript файлы, используя Webpack.

**Исходный путь**: `js/**/*js`, `!js/**/_**.js`

**Папка сборки**: `js`

**Плагины**:
- [`webpack-stream`](https://www.npmjs.com/package/webpack-stream): Интеграция Webpack с Gulp.
- [`babel-loader`](https://www.npmjs.com/package/babel-loader): Транспиляция JavaScript с использованием Babel.

**Пример выполнения**:

```bash
gulp jsTask
```

**Код**:

```javascript
export const js = {
   src: [
      `${dir.src}js/**/*js`,
      `!${dir.src}js/**/_**.js`,
   ],
   watch: `${dir.src}js/**/*js`,
   build: `${dir.build}js`,
   file: `main.js`,
};

// js:all
export function jsTask() {
   return (
      src(js.src)
         .pipe(
            plumber({
               errorHandler: notify.onError(
                  'Error jsTask(): <%= error.message %>'
               ),
            })
         )
         .pipe(newer(js.build))
         .pipe(gulpif(isDevelopment, sourcemaps.init()))
         .pipe(
            webpackStream(
               {
                  mode: isDevelopment ? 'development' : 'production',
                  output: {
                     filename: js.file,
                  },
                  module: {
                     rules: [
                        {
                           test: /\.(js)$/,
                           exclude: /(node_modules)/,
                           loader: 'babel-loader',
                           options: {
                              presets: ['@babel/preset-env'],
                           },
                        },
                     ],
                  },
               },
               webpack,
               function (err, stats) {}
            )
         )
         .pipe(gulpif(isDevelopment, sourcemaps.write()))
         .pipe(size())
         .pipe(dest(js.build))
         .pipe(browserSync.stream())
   );
}

export const jsAllTask = parallel(jsTask);
```

### Обработка SVG

**Описание**: Создает SVG спрайты для монохромных и цветных иконок.

**Исходный путь**:
- Монохромные иконки: `img/svg/mono/**/*.svg`
- Цветные иконки: `img/svg/color/**/*.svg`

**Папка сборки**: `img/svg`

**Плагины**:
- [`gulp-svg-sprite`](https://www.npmjs.com/package/gulp-svg-sprite): Создание SVG спрайтов.
- [`gulp-cheerio`](https://www.npmjs.com/package/gulp-cheerio): Манипуляции с SVG (например, удаление атрибутов `fill`).

**Пример выполнения**:

```bash
gulp svgMonoTask
gulp svgColorTask
```

**Код**:

```javascript
export const svg = {
   // настройки для монохромных svg(иконок)
   mono: {
      src: `${dir.src}img/svg/mono/**/*.svg`,
      build: `${dir.build}img/svg`,
      config: {
         mode: {
            symbol: {
               sprite: 'mono--sprite.svg',
               example: false, // не создаёт пример в html файле
               dest: '', // не создаёт на пути никаких папок
            },
         },
      },
   },
   // настройки для цветных svg изображений
   color: {
      src: `${dir.src}img/svg/color/**/*.svg`,
      build: `${dir.build}img/svg`,
      config: {
         mode: {
            symbol: {
               sprite: 'color--sprite.svg',
               example: false, // не создаёт пример в html файле
               dest: '', // не создаёт на пути никаких папок
            },
         },
      },
   },
};

// Задача для создания SVG спрайта mono
export function svgMonoTask() {
   return (
      gulp
         .src(svg.mono.src)
         .pipe(newer(svg.mono.build))
         .pipe(
            plumber({
               errorHandler: notify.onError(
                  'Error svgIconTask(): <%= error.message %>'
               ),
            })
         )
         // cheerio проходится по всем иконкам и заменяет fill на currentColor
         // позволяет менять svg иконкам цвет через scss
         .pipe(
            cheerio({
               run: function ($) {
                  $('[fill]').removeAttr('fill');
                  $('path').attr('fill', 'currentColor');
               },
               parserOptions: { xmlMode: true },
            })
         )
         .pipe(svgSprite(svg.mono.config))
         .pipe(gulp.dest(svg.mono.build))
   );
}

// Задача для создания SVG спрайта color
export function svgColorTask() {
   return gulp
      .src(svg.color.src)
      .pipe(newer(svg.color.build))
      .pipe(
         plumber({
            errorHandler: notify.onError(
               'Error svgIconTask(): <%= error.message %>'
            ),
         })
      )
      .pipe(svgSprite(svg.color.config))
      .pipe(gulp.dest(svg.color.build));
}
```

### BrowserSync

**Описание**: Запускает BrowserSync для автоматической перезагрузки страницы при изменении файлов.

**Пример выполнения**:

```bash
gulp browserSyncTask
```

**Код**:

```javascript
export const sync = {
   server: {
      proxy: serverPath,
      port: 3000,
      notify: false,
   },

   local: {
      server: { baseDir: dir.build },
      port: 7172,
      notify: false,
   },
};

export function browserSyncTask() {
   if (serverPath !== '') {
      browserSync.init(sync.server);
   } else {
      browserSync.init(sync.local);
   }
}
```

### Наблюдение за изменениями

**Описание**: Наблюдает за изменениями в файлах и автоматически запускает соответствующие задачи.

**Пример выполнения**:

```bash
gulp watchTask
```

**Код**:

```javascript
export function watchTask() {
   watch(js.watch, jsAllTask);
   watch(template.watch, templateTask);
   watch(images.watch, imagesAllTask);
   watch(scss.watch, scssTask);
}
```

### Очистка папки сборки

**Описание**: Удаляет все файлы из папки сборки.

**Пример выполнения**:

```bash
gulp del
```

**Код**:

```javascript
export function del() {
   return deleteAsync([`${dir.build}**`, `!${dir.build}---- SRC ----`], {
      force: true,
   });
}
```

### Переключение режима сборки

**Описание**: Переключает режим сборки на production. 

**Код**:

```javascript
export function isDev(done) {
   isDevelopment = false;
   console.log(`isDevelopment === ${isDevelopment}`);
   done();
}
```

## Составные задачи

### Стартовый таск

**Описание**: Очищает папку сборки, выполняет все необходимые задачи для начальной сборки.

**Пример выполнения**:

```bash
gulp start
```

**Код**:

```javascript
export const start = series(
   del,
   parallel(scssAllTask, templateTask, jsAllTask)
);
```

### Рабочий таск

**Описание**: Запускает BrowserSync и наблюдение за изменениями.

**Пример выполнения**:

```bash
gulp work
```

**Код**:

```javascript
export const work = parallel(watchTask, browserSyncTask);
```

### Финальный таск

**Описание**: Переключает режим сборки на production, очищает папку сборки и выполняет все необходимые задачи для финальной сборки.

**Пример выполнения**:

```bash
gulp end
```

**Код**:

```javascript
export const end = series(
   isDev,
   del,
   parallel(scssAllTask, templateTask, jsAllTask),
   copyIndex
);
```

