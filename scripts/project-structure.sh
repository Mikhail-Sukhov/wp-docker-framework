#!/bin/bash

# Очистка файла результата
> project-structure.txt

# Получение имени текущей папки
current_dir=$(basename "$(pwd)")

# Создание файла с заголовком
echo "Структура и содержимое папки $current_dir:" > project-structure.txt
echo "==================================================" >> project-structure.txt

# Рекурсивное сканирование файлов с исключениями
find . -type f \
    -not -path '*/node_modules/*' \
    -not -path '*/libs/*' \
    -not -path '*/\.*' \
    -not -name '.*' \
    -not -name 'package-lock.json' \
    -not -name 'project-structure.sh' \
    -not -name '*.code-workspace' \
    -print0 | while IFS= read -r -d '' file; do

    mime_type=$(file --mime-type -b "$file")

    # Запись пути к файлу
    echo "Файл: $file" >> project-structure.txt

    if [[ $mime_type == text/* || $mime_type == application/javascript || $mime_type == application/json ]]; then
        echo "Содержимое файла ${file##*/}:" >> project-structure.txt
        cat "$file" >> project-structure.txt 2>/dev/null
    else
        echo "Содержимое: [Файл не текстовый]" >> project-structure.txt
    fi

    # Явное обозначение конца файла
    echo -e "\nКонец содержимого файла ${file##*/}" >> project-structure.txt
    echo "==================================================" >> project-structure.txt
done

echo "Анализ завершен. Результат сохранен в project-structure.txt"
