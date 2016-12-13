<?php
/**
 * 	Принимает с клиента объект
 *  {"YBS":{"searchAuthor":"","searchArticle":"","searchCategory":"","searchYear":"2013"}}
 *   и просто посылает его на сервер (адрес - он знает сам)
 */
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header("Content-Type: text/html; charset=utf-8");    // кодировка

// посылаем запрос на сервер
function sendQuery($dataToAPI)
{
	// преобразуем данные
	$url  = 'http://zarchon.bget.ru/viewer/viewer_server_api.php';
	$data = array('queryToDB' => $dataToAPI);
	
	// формируем дескриптор
	$ch = curl_init();
	
	// настройки запроса
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // выводим ответ в переменную
	
	// реализуем запрос, и заносим ответ в переменную
	$result = curl_exec($ch);
	
	// закрываем соединение (удаляем дескриптор)
	curl_close($ch);

	return $result;
}
// echo '<pre>'; print_r($_POST); echo '</pre>'; exit();
		
echo sendQuery( $_POST['YBS'] );



// echo '<pre>'; print_r($_POST); echo '</pre>';
