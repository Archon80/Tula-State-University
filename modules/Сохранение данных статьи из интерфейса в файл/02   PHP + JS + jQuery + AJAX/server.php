<?php
/*
 *  Сценарий принимает набор переменных в массиве $_POST.
 *  Выполняет их проверку, перегоняет в валидную строку.
 *  Дописывает строку в файл.
 *  Profit!
 */

//**************************** Раздел 1. Настройки скрипта *************************************

ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

session_start();

//**************************** Раздел 2. Логика сценария ***************************************

$error = 'Не удалось добавить статью в файл. Обратитесь к администратору.';
$path  = '../list.txt';// адрес файла, куда будут заноситься данные

// считывает из массива POST захардкоренные значения полей формы
function getData()
{
	if(
		!isset($_POST['author']) 		||
		!isset($_POST['article_name']) 	||
		!isset($_POST['category']) 		||
		!isset($_POST['year']) 			||
		!isset($_POST['status']) 		||
		!isset($_POST['file_name']) 	||
		!isset($_POST['article_page']) 	||
		!isset($_POST['notes'])
	){
		return false;
	}

	$arrData = array(
		"author" 		=> $_POST['author'],
	    "article_name" 	=> $_POST['article_name'],
	    "category" 		=> $_POST['category'],
	    "year" 			=> $_POST['year'],
	    "status" 		=> $_POST['status'],
	    "file_name" 	=> $_POST['file_name'],
	    "article_page" 	=> $_POST['article_page'],
	    "notes" 		=> $_POST['notes']
    );

    return implode("|||", $arrData);
}

// принимает строку (с разделителями), ДОписывает ее в файл
function addDataToFile($str, $path)
{
	$res = file_put_contents($path, $str.PHP_EOL, FILE_APPEND);

	if($res) return true;
	else 	 return false;
}

//**************************** Раздел 3. Выполнение сценария ***********************************

if(empty($_POST)) exit('Статья не добавлена. Массив $_POST - пустой.');

$strData = getData();
if(!$strData) exit('Статья не добавлена. Не удалось сформировать валидную строку.');

$res = addDataToFile($strData, $path);
if(!$res) exit('Статья не добавлена. Не удалось записать валидную строку в файл.');

echo 'Статья успешно добавлена.';

//echo '<pre>'; print_r($_POST); echo '</pre>';
