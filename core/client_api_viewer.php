<?php
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header("Content-Type: text/html; charset=utf-8");    // кодировка

function sendQuery($dataToAPI)
{
	$url  = 'http://zarchon.bget.ru/viewer/viewer_server_api.php';
	$data = array('queryToDB' => $dataToAPI);
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // выводим ответ в переменную
	
	$result = curl_exec($ch);
	
	curl_close($ch);

	return $result;
}
		
echo sendQuery( $_POST['YBS'] );

