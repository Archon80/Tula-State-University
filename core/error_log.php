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

$DATE = date("y-m-d H:i");

// логи со страницы "index.php?id=articles_search" (поиск статей пользователем)
if( isset($_REQUEST['article_search']))
{
	$path = "../logs/errors_article_search.log";
	$str  = PHP_EOL.PHP_EOL.$DATE.PHP_EOL.$_REQUEST['article_search'];

	if(file_put_contents($path, $str, FILE_APPEND ) ) echo '777';
	else                                              echo '666';
}
