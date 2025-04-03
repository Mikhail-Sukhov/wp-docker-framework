#!/usr/bin/env bash

# Функция для вывода списка директорий
list_directories() {
    local path=$1
    ls -d "$path"/*/ | xargs -n 1 basename
}

# Функция для переименования директории
rename_directory() {
    local path=$1
    local old_name=$2
    local new_name=$3
    mv "$path/$old_name" "$path/$new_name"
}

# Функция для переименования файлов внутри директории
rename_files() {
    local directory=$1
    local old_name=$2
    local new_name=$3
    for file in "$directory"/*; do
        if [[ -f "$file" ]]; then
            local filename=$(basename "$file")
            local extension="${filename##*.}"
            if [[ "$extension" == "scss" ]]; then
                if [[ "$filename" == _* ]]; then
                    mv "$file" "$directory/_$new_name.$extension"
                else
                    mv "$file" "$directory/$new_name.$extension"
                fi
            else
                mv "$file" "$directory/$new_name.$extension"
            fi
        fi
    done
}

# Функция для замены текста в файлах директории
replace_text_in_files() {
    local directory=$1
    local old_name=$2
    local new_name=$3
    find "$directory" -type f -exec sed -i "s/$old_name/$new_name/g" {} +
}

# Функция для обновления файла _index.scss
update_index_scss() {
    local path=$1
    local old_name=$2
    local new_name=$3
    local index_scss_path="$path/_index.scss"

    if [[ -f "$index_scss_path" ]]; then
        if grep -q "@import \"$old_name/$old_name\";" "$index_scss_path"; then
            sed -i "s/@import \"$old_name\/$old_name\";/@import \"$new_name\/$new_name\";/g" "$index_scss_path"
        else
            echo "@import \"$new_name/$new_name\";" >> "$index_scss_path"
        fi
    fi
}

# Основная функция
main() {
    local base_path="."
    local directories=($(list_directories "$base_path"))

    if [[ ${#directories[@]} -eq 0 ]]; then
        echo "В указанной директории нет папок."
        exit 1
    fi

    echo "Доступные папки:"
    for i in "${!directories[@]}"; do
        echo "$((i+1)). ${directories[i]}"
    done

    read -p "Выберите папку (введите номер): " choice
    choice=$((choice-1))

    if [[ $choice -lt 0 || $choice -ge ${#directories[@]} ]]; then
        echo "Неверный выбор."
        exit 1
    fi

    selected_directory=${directories[choice]}
    read -p "Введите новое имя папки: " new_name

    if [[ ! "$new_name" =~ ^[a-zA-Z0-9_-]+$ ]]; then
        echo "Имя может содержать только английские буквы, цифры, символы '-' и '_'."
        exit 1
    fi

    rename_directory "$base_path" "$selected_directory" "$new_name"
    rename_files "$base_path/$new_name" "$selected_directory" "$new_name"
    replace_text_in_files "$base_path/$new_name" "$selected_directory" "$new_name"
    update_index_scss "$base_path" "$selected_directory" "$new_name"

    echo "Папка '$selected_directory' успешно переименована в '$new_name' и обновлена."
}

main