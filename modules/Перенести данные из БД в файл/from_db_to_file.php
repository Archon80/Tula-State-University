<?php
//**************************** Раздел 1. Настройки скрипта *************************************

ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');

//**************************** Раздел 2. Переменные сценария ***********************************

const DB_HOST      = 'localhost';
const DB_LOGIN     = 'root';
const DB_PASSWORD  = '';
const DB_NAME      = 'YBS';

const TABLE_NAME   = 'Articles';

const PATH_TO_FILE = 'dump.txt';

//**************************** Раздел 3. Логика сценария ***********************************

// функция принимает массив, возвращает строку
function arr2str($arr)
{
	if(getType($arr) !== 'array') exit('В функцию arr2str пришел не массив');
	return implode("|||", $arr);
}

// подключение к БД
function connect($DB_HOST, $DB_LOGIN, $DB_PASSWORD, $DB_NAME)
{
	$connectToServer = mysql_connect($DB_HOST, $DB_LOGIN, $DB_PASSWORD) or exit('Не удалось подключиться к серверу '.$DB_HOST);
	mysql_query('SET NAMES utf8');
	$chooseDB = mysql_select_db($DB_NAME) or exit('Не удалось подключиться к базе данных '.$DB_NAME);
}

// функция принимает массив, возвращает строку
function createDumpFile($arr, $file_name)
{
	if(!$arr) exit('В функцию getAllArticles не передан массив строк');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles 1-ым параметром пришел не массив');
	
	if(!$file_name) exit('В функцию getAllArticles не передано имя файла, в который будут записаны статьи');
	if(getType($file_name) !== 'string') exit('В функцию getAllArticles 2-ым параметром пришла не строка');
	
	if( file_exists($file_name) ) unlink($file_name);

	foreach($arr as $k => $v){
		file_put_contents($file_name, $v.PHP_EOL, FILE_APPEND);
	}
}

// преобразование типа содержимого переменной: из ресурса в массив (ассоциативный)
function db2array($result_set)
{
	if(!$result_set) exit('В функцию db2array не пришел параметр');
	
	$arr = array();

	while( $row = mysql_fetch_assoc($result_set) ){
		$arr[] = $row;	// циклическое заполнение массива (каждый элемент - ассоциативный массив)
	}
	
	return $arr;
}

// получаем все статьи
function getAllArticles($db_name)
{
	if(!$db_name) exit('В функцию getAllArticles не пришел параметр');
	if(getType($db_name) !== 'string') exit('В функцию getAllArticles пришла не строка');
	
	$sql = "SELECT * FROM ".$db_name." ORDER BY id_article";
	
	$result_set = mysql_query($sql) or exit('Не удалось получить статьи из таблицы '.$db_name);

	return db2array($result_set);
}

// массив массивов превращаем в массив строк
function getTotalArray($arr)
{
	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');
	
	$arrTotal = array();
	
	foreach($arr as $k => $v){
		$arrTotal[] = arr2str($v);
	}
	
	return $arrTotal;
}

//**************************** Раздел 4. Выполнение сценария ***********************************

//$text_articles = file('text.txt') or exit('Ошибка!!! Не удалось прочитать данные из файла со статьями.');// считываем содержимое файла в массив

connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);									// подключаемся к БД (и обрабатываем возможную ошибку подключения)

$articles = getAllArticles(TABLE_NAME);
$total_array = getTotalArray($articles) or exit('Не удалось преобразовать массив массивов в массив строк');											// получаем массив строк

createDumpFile($total_array, PATH_TO_FILE);											// пишем все статьи в файл
if( file_exists(PATH_TO_FILE) ) echo 'Текстовый дамп базы данных успешно создан!';	// проверка создания файла

// echo '<pre>'; print_r($total_array); echo '</pre>';