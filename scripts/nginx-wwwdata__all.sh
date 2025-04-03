#!/usr/bin/env bash
# Изменяет права и пользователя в папке WWW от имени nginx

docker exec -it lemp chown -R www-data:www-data /var/www/html/localhost/htdocs
docker exec -it lemp chmod -R 777 /var/www/html/localhost/htdocs
echo "finish"
