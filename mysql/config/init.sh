#!/bin/sh

# Проверка, пуста ли директория /var/lib/mysql
if [ ! "$(ls -A /var/lib/mysql)" ]; then
  echo "Initializing MariaDB..."
  mysql_install_db --datadir=/var/lib/mysql

  # Установка пароля root
  mysqld --defaults-file=/etc/my.cnf.d/my.cnf
  mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '123'; FLUSH PRIVILEGES;"
else
  mysqld --defaults-file=/etc/my.cnf.d/my.cnf
fi
