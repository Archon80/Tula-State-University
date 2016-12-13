<?php
/**
 *  Сценарий считывает данные из файла и вставляет их в БД.
 *  По одному сборнику за один раз.
 */
//**************************** Раздел 1. Настройки скрипта *************************************

/*
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);
*/

header('Content-type: text/html; charset=utf-8');

/////////////////////////////////////////////////
$path_to_file = 'dump.txt';
$strArticles  = '';// массив строк
$arrArticles  = '';// массив массивов

// обходим циклом массив массивов, на каждой итерации - добавляем в базу запись
function addAllArticles($arr)
{
	$db = connect();

	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');

	foreach ($arr as $key => $value) {
		addOneArticle($db, $value);
	}
}

// функция принимает массив параметров (строку), пишет данные в БД
function addOneArticle($db, $arr)
{
	if(!$arr) exit('В функцию getAllArticles не пришел параметр');
	if(getType($arr) !== 'array') exit('В функцию getAllArticles пришел не массив');

	//echo '<pre>';	var_dump($arr); 	echo '</pre>';	die();

	$author 		= clear_data($arr[1]);
	$article_name 	= clear_data($arr[2]);
	$category 		= clear_data($arr[3]);
	$year 			= clear_data($arr[4]);
	$status 		= clear_data($arr[5]);
	$filename 		= clear_data($arr[6]);
	$article_page 	= clear_data($arr[7]);
	$notes 			= clear_data($arr[8]);

	$query = "INSERT INTO Articles (author,    article_name,    category,    year,    status,    filename,    article_page,    notes)
      	  	  VALUES               ('$author', '$article_name', '$category', '$year', '$status', '$filename', '$article_page', '$notes')";

	$result = $db->prepare($query);
	$result->execute();
}

// обработка данных, пришедших от пользователя
function clear_data($data, $type="s")
{
	switch ($type){
		case 's':	return trim(htmlspecialchars(strip_tags($data)));	// если тип переменной - строка (по умолчанию)
		case 'i':	return abs( (int) $data);// если тип переменной - целое число
	}
}

// подключение к БД
function connect()
{
	$DB_HOST      = 'localhost';
	$DB_LOGIN     = 'root';
	$DB_PASSWORD  = '';
	$DB_NAME      = 'YBS';

	$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

	// подключаемся
	try {
	    $db = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME, $DB_LOGIN, $DB_PASSWORD, $options);
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}

	return $db;
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

//////////////////////////////////////////////////////////////////////////////////////////

$strArticles = file($path_to_file) or exit('Ошибка!!! Не удалось прочитать данные из файла со статьями.');
$arrArticles = str2arr($strArticles) or exit('Ошибка!!! Не удалось массив строк перегнать в массив массивов.');

addAllArticles($arrArticles);

echo 'Статьи из файла '.$path_to_file.' успешно добавлены!';

// echo '<pre>'; print_r($total_array); echo '</pre>';