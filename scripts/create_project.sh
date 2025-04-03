#!/usr/bin/env bash

# Запуск LEMP
../start.sh

# Проверка наличия awk
if ! command -v awk &> /dev/null; then
    echo "Внимание: awk не установлен в системе"
    echo "Ключи нужно будет установить вручную в файл wp-config.php"
    awk_available=false
else
    awk_available=true
fi

# Запрос имени нового проекта
while true; do
    read -p "Введите имя нового проекта (только английские буквы, цифры, символы '-' и '.', не начинающееся с '-'  или '.' или цифры, и не заканчивающееся '-' или '.'): " projectName
    if [[ $projectName =~ ^[a-zA-Z][a-zA-Z0-9-]*(\.[a-zA-Z0-9-]+)*[a-zA-Z0-9]+$ ]]; then
        break
    else
        echo "Имя проекта должно содержать только английские буквы, цифры, символы '-' и '.', не начинающееся с '-'  или '.' или цифры, и не заканчивающееся '-' или '.'."
    fi
done

# Скачивание и разархивирование WordPress
cd ../www
wget https://ru.wordpress.org/latest-ru_RU.zip

# Определение имени скачанного архива
downloaded_zip=$(ls *.zip)

unzip $downloaded_zip
rm $downloaded_zip
mv wordpress $projectName

# Копируем тему для разработки в wp-content нового проекта
cp -r wp-sample-template $projectName/wp-content/themes/

# Изменение прав доступа
docker exec -it lemp chown -R www-data:www-data /var/www/html/localhost/htdocs/$projectName
docker exec -it lemp chmod -R 777 /var/www/html/localhost/htdocs/$projectName

# Удаление точки из имени проекта и сохранение в той же переменной
dbName="${projectName//./}"

# Создание базы данных с экранированием имени
docker exec -i lemp mysql -u root -p123 -e "CREATE DATABASE \`$dbName\`;"

# Переименование и настройка wp-config.php
cd $projectName
mv wp-config-sample.php wp-config.php
sed -i "s/database_name_here/$dbName/" wp-config.php
sed -i "s/username_here/root/" wp-config.php
sed -i "s/password_here/123/" wp-config.php
sed -i "s/utf8/utf8mb4/" wp-config.php

# Генерация уникальных ключей, если awk доступен
if $awk_available; then
    keys=$(wget -q -O - https://api.wordpress.org/secret-key/1.1/salt/)

    # Проверка, что ключи были успешно получены
    if [ -z "$keys" ]; then
        echo "Ошибка: Не удалось получить ключи с сервера WordPress."
        read
        exit 1
    else
        echo "Ключи успешно получены:"
        echo "$keys"
    fi

    # Вставка ключей в wp-config.php с использованием awk
    awk -v keys="$keys" '
        /#@+/,/#@-/ {
            if (!done) {
                print keys
                done=1
                next
            }
        }
        !done { print }
        done && /#@-/ { done=0 }
    ' wp-config.php > wp-config.tmp && mv wp-config.tmp wp-config.php

    # Проверка, что ключи были успешно вставлены
    if grep -q "define('AUTH_KEY'" wp-config.php; then
        echo "Ключи успешно вставлены в wp-config.php"
    else
        echo "Ошибка: Ключи не были вставлены в wp-config.php"
        read
        exit 1
    fi
else
    echo "Ключи нужно будет установить вручную в файл wp-config.php"
fi

# Создание и настройка конфигурации Nginx
cd ../../nginx/sites
cp default.conf $projectName.conf
sed -i "s/listen 80 default_server;/listen 80;/" $projectName.conf
sed -i "s/listen \[::\]:80 default_server;/listen \[::\]:80;/" $projectName.conf
sed -i "s/server_name localhost;/server_name $projectName;/" $projectName.conf
sed -i "s/root \/var\/www\/html\/localhost\/htdocs;/root \/var\/www\/html\/localhost\/htdocs\/$projectName;/" $projectName.conf

# Добавление записи в /etc/hosts
echo "127.0.0.1 $projectName" | sudo tee -a /etc/hosts

# Перезагрузка Nginx в контейнере lemp-nginx
docker exec -it lemp nginx -s reload

# Вывод сообщения о завершении
echo "Готово! Ссылка: http://$projectName/"
echo "Операция завершена. Нажмите Enter для продолжения..."
read
