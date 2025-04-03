#!/usr/bin/env bash
docker exec -it lemp nginx -s reload
echo "Nginx перезапущен"
read -p "Нажмите Enter для продолжения..."
