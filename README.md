# wp-docker-framework

Проект "wp-docker-framework" представляет собой набор конфигураций для создания Docker LEMP-сервера для запуска WordPress. Включает в себя скрипты для автоматизации работы с WordPress, базовый шаблон "wp-sample-template" с набором готовых стилей и файлов шаблона темы WordPress, а также адаптивный SCSS-фреймворк для адаптивной верстки.

## Основные компоненты

- **LEMP-сервер**: Docker-контейнер с Nginx, PHP, MySQL и phpMyAdmin.
- **Скрипты автоматизации**: Упрощают создание проектов, управление правами доступа, экспорт данных и другие задачи.
- **Базовый шаблон WordPress**: Готовый шаблон темы с SCSS-фреймворком для быстрого старта разработки.

## Структура проекта

### Корневой каталог

- **`docker-compose.yaml`**: Конфигурация Docker Compose для запуска LEMP-сервера.
- **`lemp.Dockerfile`**: Dockerfile для создания образа LEMP-сервера. Образ построен на базе Alpine Linux и занимает не более 400 МБ.
- **`start.sh`**: Скрипт для запуска контейнеров.
- **`stop.sh`**: Скрипт для остановки контейнеров.
- **`work-container.sh`**: Скрипт для входа в контейнер.

### Скрипты

#### `start.sh`

Скрипт для запуска Docker-контейнеров. Он выполняет следующие действия:
1. Запускает контейнеры с помощью команды `docker-compose up -d`.
2. Отображает список запущенных контейнеров с помощью команды `docker ps`.
3. Ожидает нажатия Enter для завершения работы скрипта.

#### `stop.sh`

Скрипт для остановки Docker-контейнеров. Он выполняет следующие действия:
1. Останавливает контейнеры с помощью команды `docker-compose down`.
2. Отображает список запущенных контейнеров с помощью команды `docker ps`.
3. Ожидает нажатия Enter для завершения работы скрипта.

#### `work-container.sh`

1. Отображает список запущенных контейнеров с помощью команды `docker ps`
2. Ожидает нажатия Enter для завершения работы скрипта.

### Папка `scripts`

Скрипты для автоматизации работы с WordPress и Docker-контейнерами.

- **`add_host.sh`**: Добавляет домен в файл `/etc/hosts` для локальной разработки.
- **`conteiner-bash.sh`**: Открывает терминал внутри Docker-контейнера.
- **`create_project.sh`**: Создает новый WordPress-проект, настраивает базу данных и конфигурацию Nginx.
- **`nginx-restart.sh`**: Перезапускает Nginx внутри контейнера.
- **`nginx-wwwdata.sh`**: Управляет правами доступа для папки `www` внутри контейнера.
- **`sql-777.sh`**: Изменяет права доступа для папки MySQL.
- **`to_server.sh`**: Экспортирует проект для переноса на сервер, включая базу данных и файлы.
- Подробнее - [scripts/README.md](scripts/README.md)

### Папка `mysql`

Конфигурации и данные для MySQL.

- **`config/init.sh`**: Скрипт для инициализации базы данных при первом запуске.
- **`config/my.cnf`**: Конфигурационный файл для MySQL.
- **`config/root-pass.sh`**: Скрипт для  установки пароля пользователя `root`.
- **`data/`**: Директория для хранения данных MySQL.
- **`phpmyadmin/config.user.inc.php`**: Конфигурационный файл для phpMyAdmin.
- Подробнее - [mysql/README.md](mysql/README.md)

#### Логин и пароль для MySQL
- **Логин**: `root`
- **Пароль**: `123`

### Папка `nginx`

Конфигурации и логи для Nginx.

- **`log/`**: Директория для хранения логов Nginx.
- **`sites/default.conf`**: Конфигурация по умолчанию для Nginx.
- **`sites/phpinfo.conf`**: Конфигурация для отображения phpinfo.
- **`sites/phpmyadmin.conf`**: Конфигурация для доступа к phpMyAdmin.
- Подробнее - [nginx/README.md](nginx/README.md)

#### phpMyAdmin
phpMyAdmin доступен по адресу: [http://127.0.0.1:5000/](http://127.0.0.1:5000/)

### Папка `php`

Конфигурации для PHP.

- **`config/php-fpm.conf`**: Конфигурационный файл для PHP-FPM.
- **`config/php.ini`**: Конфигурационный файл для PHP.
- Подробнее - [php/README.md](php/README.md)

### Папка `www`

Директория для хранения файлов проектов.

- **`phpinfo/index.php`**: Файл для отображения информации о PHP.
- **`wp-sample-template/`**: Базовый шаблон темы WordPress. Подробнее о шаблоне можно узнать в [README.md шаблона](www/wp-sample-template/---- SRC ----/README.md).

## Лицензия

Проект распространяется под лицензией MIT. Полный текст лицензии приведен ниже.

### Лицензия MIT (на английском)

```text
MIT License

Copyright (c) [год] [автор]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### Лицензия MIT (на русском)

```text
Лицензия MIT

Copyright (c) [год] [автор]

Данная лицензия разрешает лицам, получившим копию данного программного обеспечения и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»), безвозмездно использовать Программное Обеспечение без ограничений, включая неограниченное право на использование, копирование, изменение, слияние, публикацию, распространение, сублицензирование и/или продажу копий Программного Обеспечения, а также лицам, которым предоставляется данное Программное Обеспечение, при соблюдении следующих условий:

Указанное выше уведомление об авторском праве и данные условия должны быть включены во все копии или значимые части данного Программного Обеспечения.

ДАННОЕ ПРОГРАММНОЕ ОБЕСПЕЧЕНИЕ ПРЕДОСТАВЛЯЕТСЯ «КАК ЕСТЬ», БЕЗ КАКИХ-ЛИБО ГАРАНТИЙ, ЯВНО ВЫРАЖЕННЫХ ИЛИ ПОДРАЗУМЕВАЕМЫХ, ВКЛЮЧАЯ ГАРАНТИИ ТОВАРНОЙ ПРИГОДНОСТИ, СООТВЕТСТВИЯ ПО ЕГО КОНКРЕТНОМУ НАЗНАЧЕНИЮ И ОТСУТСТВИЯ НАРУШЕНИЙ, НО НЕ ОГРАНИЧИВАЯСЬ ИМИ. НИ В КАКОМ СЛУЧАЕ АВТОРЫ ИЛИ ПРАВООБЛАДАТЕЛИ НЕ НЕСУТ ОТВЕТСТВЕННОСТИ ПО КАКИМ-ЛИБО ИСКАМ, ЗА УЩЕРБ ИЛИ ПО ИНЫМ ТРЕБОВАНИЯМ, В ТОМ ЧИСЛЕ, ПРИ ДЕЙСТВИИ КОНТРАКТА, ДЕЛИКТЕ ИЛИ ИНОЙ СИТУАЦИИ, ВОЗНИКШИМ ИЗ-ЗА ИСПОЛЬЗОВАНИЯ ПРОГРАММНОГО ОБЕСПЕЧЕНИЯ ИЛИ ИНЫХ ДЕЙСТВИЙ С ПРОГРАММНЫМ ОБЕСПЕЧЕНИЕМ.
```
