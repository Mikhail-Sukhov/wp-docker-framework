#!/usr/bin/env bash
# Изменяет права и пользователя в папке mysql от имени mysql
docker exec -it lemp chmod -R 777 /var/lib/mysql
echo "Операция завершена. Нажмите Enter для продолжения..."
read
