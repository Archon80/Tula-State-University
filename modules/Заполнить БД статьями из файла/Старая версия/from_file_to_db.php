<?php
/**
 *  Сценарий считывает данные из файла и вставляет их в БД.
 *  По одному сборнику за один раз.
 */
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

$strArticles     = ''; 			// массив строк
$arrArticles     = ''; 			// массив массивов

//**************************** Раздел 3. Логика сценария ***********************************

// подключение к БД
function connect($DB_HOST, $DB_LOGIN, $DB_PASSWORD, $DB_NAME)
{
	$connectToServer = mysql_connect($DB_HOST, $DB_LOGIN, $DB_PASSWORD) or exit('Не удалось подключиться к серверу '.$DB_HOST.': '.mysql_error());
	mysql_query('SET NAMES utf8');
	$chooseDB = mysql_select_db($DB_NAME) or exit('Не удалось подключиться к базе данных '.$DB_NAME.': '.mysql_error());
}

// массив строк превращаем в массив массивов
function str2arr($arr)
{
	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');
	
	$arrTotal = array();
	
	foreach($arr as $k => $v){
		$arrTotal[] = explode("|||", $v);
	}
	
	return $arrTotal;
}

// функция принимает массив параметров (строку), пишет данные в БД
function addOneArticle($arr)
{
	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');

	$t = "INSERT INTO articles (author, article_name, category,  year, status, filename, article_page, notes)
	      VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
	
	$sql = sprintf($t, $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8]);
	
	mysql_query($sql) or exit('Ошибка!!! Не удалось добавить очередную статью из массива массивов в базу данных: '.mysql_error() );
}

// обходим циклом массив массивов, на каждой итерации - добавляем в базу запись
function addAllArticles($arr)
{
	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');

	foreach ($arr as $key => $value) {
		addOneArticle($value);
	}
}

//**************************** Раздел 4. Выполнение сценария ***********************************

$strArticles = file(PATH_TO_FILE) or exit('Ошибка!!! Не удалось прочитать данные из файла со статьями.');
$arrArticles = str2arr($strArticles) or exit('Ошибка!!! Не удалось массив строк перегнать в массив массивов.');

connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
addAllArticles($arrArticles);

echo 'Статьи из файла '.PATH_TO_FILE.' успешно добавлены в базу '.DB_NAME.' в таблицу '.TABLE_NAME;

// echo '<pre>'; print_r($total_array); echo '</pre>';