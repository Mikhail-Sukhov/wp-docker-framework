'use strict';

/*******************************************************************************************************************************************\
					######    ###  ####  ###### ##  ## ##  ## ##   ##
					##  ##   # ## ##  ## ##     ##  ## ##  ## ##   ##
					##  ##  #  ## ###### ##     ## ### ###### #### ##
					##  ## ##  ## ##  ## ##     ### ## ##  ## ## # ##
					##  ## ##  ## ##  ## ##     ##  ## ##  ## #### ##
\*******************************************************************************************************************************************/

// Сервер для работы сайта
const serverPath = 'http://wpt.localsite/';

// исходная папка и папка билда
const dir = {
   src: '../',
   build: '../../',
};

// gulp и общие плагины
import gulp from 'gulp'; // основной демон gulp
import { src, dest, series, parallel, watch } from 'gulp'; // чтобы не писать gulp.src, gulp.dest и т.д.
import sourcemaps from 'gulp-sourcemaps'; // создаёт sourcemaps
import newer from 'gulp-newer'; // исключает файлы без изменений и наличиствующие
import plumber from 'gulp-plumber'; // не останавливает gulp если произошла ошибка
import notify from 'gulp-notify'; // выводит системные уведомления
import gulpif from 'gulp-if'; // if условия, для build и dev сборки
import { deleteAsync } from 'del'; // удаляет файлы и каталоги
import browserSync from 'browser-sync'; // browser-sync
import rename from 'gulp-rename'; // переименовывает имена и пути файлов
import size from 'gulp-size'; // выводит размер файла в потоке
import map from 'map-stream'; // позволяет выводить поток в переменную

// плагины изображений
import svgSprite from 'gulp-svg-sprite'; // создаёт спрайты из svg
import cheerio from 'gulp-cheerio'; // манипулирует xml включая svg
import gulpImage from 'gulp-image'; // оптимизация изображений

// Плагины scss
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);

// Плагины postcss
import postcss from 'gulp-postcss'; // демон для postcss плагинов
import autoprefixer from 'autoprefixer'; // добавляет вендорные префиксы
import assets from 'postcss-assets'; // автопути к изображениям по названию
import pxtorem from 'postcss-pxtorem'; // Конвертирует rem в px и наоборот
import cssnano from 'cssnano'; // Минификатор от postCss
import sortMediaQueries from 'postcss-sort-media-queries'; // сортирует media-queries
import cssMerge from 'postcss-merge-rules'; // сортирует одинаковые классы с разными стилями в один

// Плагины Html
import remHtmlComm from 'gulp-remove-html-comments'; // удаляет комментарии из html
import cachebust from 'gulp-cache-bust'; // добавляет кэш в ссылки на файлы
import gulpTemplate from 'gulp-template'; // замена шаблонов типа <%= Переменная %>

// Модули node.js
import path from 'path'; // Модуль для работы с путями
import fs from 'fs'; // Модуль для работы с файловой системой

// Плагины js
import webpack from 'webpack'; // webpack нужно для работы с gulp watch
import webpackStream from 'webpack-stream'; // движок webpack

// Импорт package.json для управления зависимостями в libs.moduleFiles()
const packageJson = JSON.parse(
   fs.readFileSync(path.resolve(`${dir.src}package.json`), 'utf8')
);

// Проверка на сборку, если True, то development, если false, то production
let isDevelopment = true;
console.log(`isDevelopment === ${isDevelopment}`);

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

/*******************************************************************************************************************************************\
					###### ##   #  ####   ####  #####   ####
					  ##   ### ## ##  ## ##     ##     ##
					  ##   ## # # ###### ## ### ####    ####
					  ##   ##   # ##  ## ##  ## ##         ##
					###### ##   # ##  ##  ####  #####   ####
\*******************************************************************************************************************************************/
// todo

/* Использование mono спрайта
<svg class="">
   <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/mono--sprite.svg#wordpress"></use>
</svg>
*/
/* Использование color спрайта
<svg class="">
   <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/color--sprite.svg#wordpress"></use>
</svg>
*/

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
   },
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

export const imagesAllTask = parallel(imagesTask, svgMonoTask, svgColorTask);

/*******************************************************************************************************************************************\
					######  ####  ##  ## ######
					##     ##  ## ### ##   ##
					####   ##  ## ## ###   ##
					##     ##  ## ##  ##   ##
					##      ####  ##  ##   ##
\*******************************************************************************************************************************************/

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

/*******************************************************************************************************************************************\
					##     ###### #####   ####
					##       ##   ##  ## ##
					##       ##   #####   ####
					##       ##   ##  ##     ##
					###### ###### #####   ####
\*******************************************************************************************************************************************/

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
   return src(libs.moduleFiles(), {
      base: dir.src + 'node_modules',
      encoding: false,
   })
      .pipe(newer('libs'))
      .pipe(
         plumber({
            errorHandler: notify.onError('<%= error.message %>'),
         })
      )
      .pipe(dest(dir.src + 'libs'));
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

/*******************************************************************************************************************************************\
                ####   ####   ####   ####
               ##     ##  ## ##     ##
               ####  ##      ####   ####
                  ## ##  ##     ##     ##
               ####   ####   ####   ####
\*******************************************************************************************************************************************/

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
         loadPaths: ['../img/**', '../font/**', '../libs/**'],
         cachebuster: true,
         basePath: '../',
         baseUrl: './',
      }),
   ],

   // Настройки postcss pxtorem
   pxtorem: [
      pxtorem({
         rootValue: 16, // Исходный размер
         propList: ['*'], // Свойства подверженные изменениям
         unitPrecision: 4, // Количество символов после запятой. Нужно 4 т.к. такая же точность в нативном css в браузерах
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

/*******************************************************************************************************************************************\
					###### #####  ##   # #####
					  ##   ##     ### ## ##  ##
					  ##   ####   ## # # #####
					  ##   ##     ##   # ##
					  ##   #####  ##   # ##
\*******************************************************************************************************************************************/

export const template = {
   src: `${dir.src}template/**/*.{html,php,js}`,
   watch: `${dir.src}template/**/*.{html,php,js}`,
   build: dir.build,
};

export function templateTask() {
   return (
      src(template.src)
         .pipe(
            plumber({
               errorHandler: notify.onError(
                  'Error templateTask(): <%= error.message %>'
               ),
            })
         )
         .pipe(newer(template.build))
         // заменяет <%= theme %> на путь к папке шаблона WP
         .pipe(
            gulpTemplate(
               {
                  theme: themeFolderName,
               },
               {
                  interpolate: /<%=([\s\S]+?)%>/g, // Только <%= ... %>
                  escape: /<%-([\s\S]+?)%>/g,
                  evaluate: /<%([\s\S]+?)%>/g,
               }
            )
         )
         .pipe(gulpif(!isDevelopment, cachebust({ type: 'timestamp' })))
         .pipe(gulpif(!isDevelopment, remHtmlComm()))
         .pipe(size())
         .pipe(dest(template.build))
   );
}

/*******************************************************************************************************************************************\
					######  ####
					    ## ##
					    ##  ####
					##  ##     ##
					 ####   ####
\*******************************************************************************************************************************************/

export const js = {
   src: [`${dir.src}js/**/*js`, `!${dir.src}js/**/_**.js`],
   watch: `${dir.src}js/**/*js`,
   build: `${dir.build}js`,
   file: `main.js`,
};

// js:all
export function jsTask() {
   return src(js.src)
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
      .pipe(browserSync.stream());
}

export const jsAllTask = series(libsAllTask, jsTask);

/*******************************************************************************************************************************************\
                            ###### ##  ## #####  #####  ##  ##     ##  ## ###### ##   # ##
                              ##   ### ## ##  ## ##      ####      ##  ##   ##   ### ## ##
                              ##   ## ### ##  ## ####     ##       ######   ##   ## # # ##
                              ##   ##  ## ##  ## ##      ####      ##  ##   ##   ##   # ##
                            ###### ##  ## #####  #####  ##  ## ##  ##  ##   ##   ##   # #####
\*******************************************************************************************************************************************/

// Функция для рекурсивного получения всех подпапок в целевой директории
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
         files.forEach((file) => {
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

// Задача для копирования index.html во все подпапки ${dir.build}
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
            .pipe(
               plumber({
                  errorHandler: notify.onError(
                     'Error copyIndexToSubfolders(): <%= error.message %>'
                  ),
               })
            )
            .pipe(dest(folder))
            .on('end', resolve)
            .on('error', reject);
      });
   }
}

/*******************************************************************************************************************************************\
					 ####  ##  ## ##  ##  ####
					##      ####  ### ## ##  ##
					 ####    ##   ## ### ##
					    ##   ##   ##  ## ##  ##
					 ####    ##   ##  ##  ####
\*******************************************************************************************************************************************/

export const sync = {
   server: {
      proxy: serverPath,
      port: 3000,
      notify: false,

      // cors: true,
      // proxy: {
      //    target: serverPath,
      //    ws: true,
      //    proxyReq: [
      //       function(proxyReq) {
      //          proxyReq.setHeader('Access-Control-Allow-Origin', '*');
      //       }
      //    ]
      // },
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

/*******************************************************************************************************************************************\
					##   ##  ####   ######   ####   ##  ##
					##   ## ##  ##    ##    ##  ##  ##  ##
					## # ## ######    ##    ##      ######
					####### ##  ##    ##    ##  ##  ##  ##
					 ## ##  ##  ##    ##     ####   ##  ##
\*******************************************************************************************************************************************/

export function watchTask() {
   watch(js.watch, jsAllTask);
   watch(template.watch, templateTask);
   watch(images.watch, imagesAllTask);
   watch(scss.watch, scssTask);
}

/*******************************************************************************************************************************************\
					######  ####   ####  ##  ##
					  ##   ##  ## ##     ## ##
					  ##   ######  ####  ####
					  ##   ##  ##     ## ## ##
					  ##   ##  ##  ####  ##  ##
\*******************************************************************************************************************************************/

// Переключает isDevelopment на false. Необходим для финишной сборки
export function isDev(done) {
   isDevelopment = false;
   console.log(`isDevelopment === ${isDevelopment}`);
   done();
}

// Очищает папку сборки
export function del() {
   return deleteAsync([`${dir.build}**`, `!${dir.build}---- SRC ----`], {
      force: true,
   });
}

// Стартовый таск
export const start = series(
   del,
   libsAllTask,
   parallel(
      series(parallel(fontTask, imagesAllTask), scssTask),
      templateTask,
      jsTask
   )
);

// Рабочий таск
export const work = parallel(watchTask, browserSyncTask);

// Финальный таск
export const end = series(
   isDev,
   del,
   libsAllTask,
   parallel(
      series(parallel(fontTask, imagesAllTask), scssTask),
      templateTask,
      jsTask
   ),
   copyIndex
);
