#!/usr/bin/env bash
# Изменяет права и пользователя в папке WWW от имени nginx

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
    read -p "Выберите номер проекта, в котором вы хотите изменить права" projectNumber
    if [[ $projectNumber =~ ^[0-9]+$ ]] && [ $projectNumber -ge 1 ] && [ $projectNumber -le ${#projectFolders[@]} ]; then
        dir=${projectFolders[$((projectNumber-1))]}
        break
    else
        echo "Неверный выбор. Пожалуйста, выберите номер из списка."
    fi
done

# Проверка наличия папки старого проекта
if [ ! -d "../www/$dir" ]; then
    echo "Папка проекта $dir не найдена."
    exit 1
fi

# Выводим список вариантов прав доступа
echo "Выберите вариант прав доступа:"
echo "1) 777 для всех файлов и каталогов"
echo "2) 755 для каталогов и 644 для файлов"
read -p "Введите номер варианта: " permission_option

# Применяем команды к выбранному каталогу с учетом выбранных прав доступа
case $permission_option in
    1)
        docker exec -it lemp chown -R www-data:www-data /var/www/html/localhost/htdocs/$dir
        docker exec -it lemp chmod -R 777 /var/www/html/localhost/htdocs/$dir
        echo "Установлены права 777 для каталога: $dir"
        ;;
    2)
        docker exec -it lemp chown -R www-data:www-data /var/www/html/localhost/htdocs/$dir
        docker exec -it lemp find /var/www/html/localhost/htdocs/$dir -type d -exec chmod 755 {} + -o -type f -exec chmod 644 {} +
        echo "Установлены права 755 для каталогов и 644 для файлов в каталоге: $dir"
        ;;
    *)
        echo "Неверный выбор прав доступа."
        exit 1
        ;;
esac

echo "Операция завершена"
read -p "Нажмите Enter для продолжения..."
