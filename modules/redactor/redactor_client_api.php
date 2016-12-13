<?php
/*
	Сценарий принимает с клиента объект следуюшего типа:
		array(
		    "fromRedactor" => array(			// этот ключ - постоянный: нужен для отслеживание объекта, который пришел с клиента
	            "getArticles" => array(			// этот ключ - разный (добавление, изменение, удаление статьи)
	                    [searchAuthor] => 
	                    [searchArticle] => 
	                    [searchCategory] => 
	                    [searchYear] => 
	                )

		        )

		)
*/


// настройки соединения
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');

/////////////////////////////////////////////////

// функция для посылания запроса на сервер
function sendQuery($dataToAPI)
{

	// преобразуем данные
	$url  = 'http://zarchon.bget.ru/redactor/redactor_server_api.php';
	$data = array('queryToDB' => $dataToAPI);

	/*
		Посылаем на серверную часть API объект следующего вида:
			array(
			    "queryToDB" => array(			// этот ключ - постоянный: нужен для отслеживание объекта
		            "getArticles" => array(		// этот ключ - разный (добавление, изменение, удаление статьи)
		                    [searchAuthor] => 
		                    [searchArticle] => 
		                    [searchCategory] => 
		                    [searchYear] => 
		                )

			        )

			)
	*/
	//echo '<pre>'; print_r($dataToAPI); echo '</pre>'; exit();

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
echo '<pre>'; print_r($_POST); echo '</pre>'; exit();

// проверяем, пришел ли запрос с сайта
if( !isset($_POST['fromRedactor']) ){
	echo 'В АПИ клиента (файл client_api.php) не поступили данные, и $_POST["fromRedactor"] - не существует';
	exit();
}

// делаем запрос, получаем ответ и выводим его		
echo sendQuery( $_POST['fromRedactor'] );




//echo '<pre>'; print_r($_POST); echo '</pre>'; exit();