<?php
/*
	Сценарий принимает объект данных следующего типа:
		array(
			"queryToDB" => array(					// этот ключ - постоянен, по нему отслеживают объект с клиентской части АПИ
				"getArticles" => array(				// этот ключ - в разных запросах разный
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

class DB {

	const HOST 		 = 'localhost';
	const DB_NAME 	 = 'zarchon_80';
	const LOGIN 	 = 'zarchon_80';
	const PASSWORD 	 = '290980';
	const TABLE_NAME = 'Articles';

	// добавить статью
	public function addArticle($arr)
	{
		// проверяем наличие данных, обрабатываем их и пишем в переменные
		if( isset($arr['cnt']) && $arr['cnt'] != '' ){
			$cnt = $this->clear_data($arr['cnt']);
		}
		else {
			echo 'Поле cnt не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		// не хочу дублировать большое количество кода, поэтому и INSERT, и UPDATE - тут
		if( isset($arr['id_article']) && $arr['id_article'] != '' ){
			$id_article = $this->clear_data($arr['id_article']);
		}
		else {
			$id_article = '';// и та-а-а-ак сойдет...
		}

		if( isset($arr['author']) && $arr['author'] != '' ){
			$author = $this->clear_data($arr['author']);
		}
		else {
			echo 'Поле author не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['article_name']) && $arr['article_name'] != '' ){
			$article_name = $this->clear_data($arr['article_name']);
		}
		else {
			echo 'Поле article_name не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['category']) && $arr['category'] != '' ){
			$category = $this->clear_data($arr['category']);
		}
		else {
			echo 'Поле category не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['year']) && $arr['year'] != '' ){
			$year = $this->clear_data($arr['year']);
		}
		else {
			echo 'Поле year не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['status']) && $arr['status'] != '' ){
			$status = $this->clear_data($arr['status']);
		}
		else {
			echo 'Поле status не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['filename']) && $arr['filename'] != '' ){
			$filename = $this->clear_data($arr['filename']);
		}
		else {
			echo 'Поле filename не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['article_page']) && $arr['article_page'] != '' ){
			$article_page = $this->clear_data($arr['article_page']);
		}
		else {
			echo 'Поле article_page не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		if( isset($arr['notes']) && $arr['notes'] != '' ){
			$notes = $this->clear_data($arr['notes']);
		}
		else {
			echo 'Поле notes не обнаружено. Либо такого поля нет, либо оно пришло пустым.';
			exit();
		}

		$db = $this->dbConnect();

		// в зависимости от присланного флага aформируем запрос:
		// добавляем в БД новую статью или редактируем существующую
		if($cnt == 'add'){
			$q = "INSERT INTO Articles (author,    article_name,    category,    year,    status,    filename,    article_page,    notes)
		      	  VALUES               ('$author', '$article_name', '$category', '$year', '$status', '$filename', '$article_page', '$notes')";
		}
		if($cnt == 'update'){
			$q =   "UPDATE Articles
				  	SET
				  		author 		 = '$author',
				  		article_name = '$article_name',
				  		category     = '$category',
				  		year		 = '$year',
				  		status 		 = '$status',
				  		filename 	 = '$filename',
				  		article_page = '$article_page',
				  		notes 	 	 = '$notes'
			  	   	WHERE
			  	   		id_article   = $id_article";
		}

		// исполняем запрос
		$query = $db->prepare($q);
		$query->execute();

		return 7;
	}

	// обработка данных, пришедших от пользователя
	private function clear_data($data, $type="s")
	{
		switch ($type){
			case 's':	return trim(htmlspecialchars(strip_tags($data)));	// если тип переменной - строка (по умолчанию)
			case 'i':	return abs( (int) $data);// если тип переменной - целое число
		}
	}

	// подключение к БД
	private function dbConnect()
	{
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		// подключаемся
		try {
		    $db = new PDO('mysql:host='.self::HOST.';dbname='.self::DB_NAME, self::LOGIN, self::PASSWORD, $options);
		    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
		    echo 'ERROR: ' . $e->getMessage();
		}

		return $db;
	}

	// удалить статью
	public function deleteArticle($id_article)
	{
		$db = $this->dbConnect();

		$q = "DELETE FROM ".self::TABLE_NAME." WHERE id_article=$id_article";

		$query  = $db->prepare($q);
		$query->execute();

		$db = null;

		return $query;
	}

	// получить все статьи
	public function getAllArticles($data)
	{
		//echo '<pre>'; print_r($arr); echo '</pre>'; exit();

		$q = "SELECT * FROM ".self::TABLE_NAME." WHERE id_article NOT LIKE '00'";

		if( $data['searchAuthor'] ) 	$q .= " AND author LIKE '" 		. $data['searchAuthor']  . "%'";// ЧАСТИЧНЫЙ поиск по автору
		if( $data['searchArticle'] )	$q .= " AND article_name LIKE '". $data['searchArticle'] . "%'";// ЧАСТИЧНЫЙ поиск по названию статьи
		if( $data['searchCategory'] )	$q .= " AND category='" 		. $data['searchCategory']. "'";	// поиск по категории
		if( $data['searchYear'] ) 		$q .= " AND year="				. $data['searchYear'];							// поиск по году выхода
		
		$q .= " ORDER BY id_article DESC";


		$db = $this->dbConnect();

		$query = $db->prepare($q);
		$query->execute();
		$result = $query->fetchAll();

		$db = null;

		return $result;
	}

	// получить одну статью
	public function getArticle($id_article)
	{
		$db = $this->dbConnect();

		$q = "SELECT * FROM " . self::TABLE_NAME . " WHERE id_article='$id_article'";

		$query  = $db->prepare($q);
		$query->execute();
		$result = $query->fetchAll();

		$db = null;

		return $result;
	}
}


///////////////////////////////////////////////////////////////////////////////////

// проверяем, пришел ли запрос с сайта
if( !isset($_POST['queryToDB']) ){
	echo 'В АПИ не поступили данные, и $_POST["queryToDB"] - не существует';
	exit();
}

// получаем массив "ключ - объект данных", например, array('getArticles' => array(...) )
$objData = $_POST['queryToDB'];

// создаем экземпляр класса
$db = new DB();



// получить все статьи
if ( isset($objData['getArticles']) && $objData['getArticles'] != '') {
	$result = $db->getAllArticles($objData['getArticles']);
	echo json_encode($result);
}

// получить одну статью
if ( isset($objData['getArticle']) && $objData['getArticle'] != '') {
	$result = $db->getArticle($objData['getArticle']);
	echo json_encode($result[0]);
}

// добавить статью
if ( isset($objData['addArticle']) && $objData['addArticle'] != '') {
	$result = $db->addArticle($objData['addArticle']);
	echo json_encode($result);
}

// редактировать статью
if ( isset($objData['editArticle']) && $objData['editArticle'] != '') {
	$result = $db->addArticle($objData['editArticle']);
	echo json_encode($result);
}

// редактировать статью
if ( isset($objData['deleteArticle']) && $objData['deleteArticle'] != '') {
	$result = $db->deleteArticle($objData['deleteArticle']);
	echo json_encode($result);
}
