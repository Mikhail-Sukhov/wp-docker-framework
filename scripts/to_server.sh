#!/usr/bin/env bash

# Запуск LEMP
../start.sh

# Сканирование папок в директории ../www/
projectFolders=($(ls ../www/))

# Вывод списка папок и запрос выбора старого проекта
echo "Доступные проекты:"
for i in "${!projectFolders[@]}"; do
    echo "$((i+1)). ${projectFolders[i]}"
done

while true; do
    read -p "Выберите номер проекта, который хотите экспортировать: " projectNumber
    if [[ $projectNumber =~ ^[0-9]+$ ]] && [ $projectNumber -ge 1 ] && [ $projectNumber -le ${#projectFolders[@]} ]; then
        oldProjectName=${projectFolders[$((projectNumber-1))]}
        break
    else
        echo "Неверный выбор. Пожалуйста, выберите номер из списка."
    fi
done

# Проверка наличия папки старого проекта
if [ ! -d "../www/$oldProjectName" ]; then
    echo "Папка проекта $oldProjectName не найдена."
    exit 1
fi

# Изменение прав доступа для папок и файлов на 777
docker exec -it lemp chmod -R 777 /var/www/html/localhost/htdocs/$oldProjectName

# Создание папки to_server
mkdir -p "../www/$oldProjectName/to_server"

# Создаем архив, исключая указанные папки
tar -czf "../www/$oldProjectName/to_server/to_server.tar.gz" \
    --exclude="*/to_server" \
    --exclude="*/---- SRC ----" \
    -C "../www/$oldProjectName" .

# Экспорт базы данных
docker exec -i lemp mysqldump -u root -p123 "$oldProjectName" > "../www/$oldProjectName/to_server/to_server.sql"

# Запрос нового url для замены в базе данных
read -p "Введите новое имя домена без pttp/https: " newUrl

# Замена всех вхождений имени старого проекта на новый Url в SQL файле
sed -i "s/$oldProjectName/$newUrl/g" "../www/$oldProjectName/to_server/to_server.sql"
        
# Вывод сообщения о завершении
echo "Готово! Архив и база данных для экспорта проекта $oldProjectName находятся в папке to_server."
echo "Операция завершена. Нажмите Enter для продолжения..."
read
