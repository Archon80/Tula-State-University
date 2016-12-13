<?php
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header("Content-Type: text/html; charset=utf-8");    // кодировка

// проверяем, пришел ли запрос с сайта
if( !isset($_REQUEST['queryToDB']) ){
	echo 'В АПИ не поступили данные, и $_REQUEST["ueryToDB"] - не существует';
	exit();
}

// настройки подключения
$host    = 'localhost';
$dbname  = 'zarchon_80';
$user    = 'zarchon_80';
$pass    = '290980';
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

function createQuery($data)
{
	if(!$data){ echo 'В функцию createQuery не поступил параметр.'; exit(); }
	if(getType($data) != 'array'){ echo 'В функцию createQuery поступил не массив.'; exit(); }
	
	$queryToDB = "SELECT * FROM Articles WHERE id_article NOT LIKE '00'";

	if( $data['searchAuthor'] ) 	$queryToDB .= " AND author LIKE '" 		. $data['searchAuthor']  . "%'";// ЧАСТИЧНЫЙ поиск по автору
	if( $data['searchArticle'] )	$queryToDB .= " AND article_name LIKE '". $data['searchArticle'] . "%'";// ЧАСТИЧНЫЙ поиск по названию статьи
	if( $data['searchCategory'] )	$queryToDB .= " AND category='" 		. $data['searchCategory']. "'";	// поиск по категории
	if( $data['searchYear'] ) 		$queryToDB .= " AND year="				. $data['searchYear'];							// поиск по году выхода

	$queryToDB .= " ORDER BY id_article DESC";

	return $queryToDB;
}

// подключаемся
try {
    $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass, $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

// готовим запрос
$q = createQuery($_REQUEST['queryToDB']);

// осуществляем запрос
$query = $db->prepare($q);
$query->execute();
$result = $query->fetchAll();

// закрываем соединение
$db = null;

// выводим результат
echo json_encode($result);







//echo '<pre>'; print_r($_REQUEST['queryToDB']); echo '</pre>'; die();




/*
	МОЙ сайт (цветочный)
	--------------------
	define('DB_HOST', 'localhost');
	define('DB_LOGIN', 'zarchon_80');
	define('DB_PASSWORD', '290980');
	define('DB_NAME', 'zarchon_80');

	ТВОЙ сайт (Петерхост)
	---------------------
	define('DB_HOST', 'mysql.boryak.z8.ru');
	define('DB_LOGIN', 'dbu_boryak_3');
	define('DB_PASSWORD', '5NPVpkC3XBL');
	define('DB_NAME', 'db_boryak_3');
	
	Еще раз перезатрешь мои данные - убью!!! )))
*/