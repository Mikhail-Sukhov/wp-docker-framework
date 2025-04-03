#!/bin/sh

# Функция для проверки, запущен ли MySQL сервер
check_mysql_running() {
    while true; do
        if mysqladmin -u root ping &> /dev/null; then
            echo "MySQL сервер запущен."
            break
        else
            echo "MySQL сервер не запущен. Ожидание..."
            sleep 5
        fi
    done
}

# Проверка, запущен ли MySQL сервер
check_mysql_running

# Смена пароля пользователя root
mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '123'; FLUSH PRIVILEGES;"

echo "Пароль пользователя root успешно изменен."
