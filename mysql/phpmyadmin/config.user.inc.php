<?php

$i = 0;

/**
 * Первый сервер
 */
$i++;
/* Тип аутентификации */
$cfg['Servers'][$i]['auth_type'] = 'cookie'; // Измените на 'config' для автоматического входа
/* Параметры сервера */
$cfg['Servers'][$i]['host'] = '0.0.0.0'; // Хост MariaDB
$cfg['Servers'][$i]['port'] = '3306'; // Порт MariaDB
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['AllowNoPassword'] = false;

/**
 * Директории для сохранения/загрузки файлов с сервера
 */
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';
$cfg['TempDir'] = '/usr/share/webapps/phpmyadmin/tmp/';

/**
 * Отключение стандартного предупреждения, которое отображается на странице "Структура базы данных"
 * если какая-либо из необходимых таблиц для функций отношений отсутствует в базе данных.
 */
$cfg['PmaNoRelation_DisableWarning'] = true;
