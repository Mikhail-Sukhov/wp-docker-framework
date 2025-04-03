<?php
// Получаем текущую часовую зону
$timezone = date_default_timezone_get();

// Выводим часовую зону
echo "Текущая часовая зона: " . $timezone . "\n";
?>

<?php
// Вывод текущей даты и времени в формате "ГГГГ-ММ-ДД ЧЧ:ММ:СС"
echo date("Y-m-d H:i:s");

?>

<?php


phpinfo();



?>
