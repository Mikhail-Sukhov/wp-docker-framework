#!/usr/bin/env bash

# Путь к папке WWW
WWW_DIR="../www"

# Получаем список папок в WWW
folders=($(ls -d $WWW_DIR/*/))

# Выводим список папок для выбора
echo "Выберите папку из списка:"
for i in "${!folders[@]}"; do
  echo "$((i+1)). ${folders[i]}"
done

# Считываем выбор пользователя
read -p "Введите номер папки: " choice

# Проверяем, что выбор в пределах допустимого диапазона
if [[ $choice -ge 1 && $choice -le ${#folders[@]} ]]; then
  # Получаем выбранную папку
  selected_folder=${folders[$((choice-1))]}

  # Извлекаем имя папки из полного пути
  domenName=$(basename "$selected_folder")

  # Добавляем запись в файл hosts
  echo "127.0.0.1 $domenName" | sudo tee -a /etc/hosts

  echo "Запись '127.0.0.1 $domenName' добавлена в /etc/hosts"
else
  echo "Неверный выбор. Пожалуйста, выберите номер из списка."
fi

echo "Операция завершена"
read -p "Нажмите Enter для продолжения..."
