<?php
/*
 *  1. Заполнение формы (данные статьи)
 *  2. Сохранение в файл
 *
 *  (вариант с PHP + JavaScript + sessions)
 */

//**************************** Раздел 1. Настройки скрипта *************************************

ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');
session_start();

//**************************** Раздел 2. Логика сценария ***************************************

$error = '';
$path  = 'list.txt';// адрес файла, куда будут заноситься данные

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
	file_put_contents($path, $str.PHP_EOL, FILE_APPEND);
}

//**************************** Раздел 3. Выполнение сценария ***********************************

if(!empty($_POST)){
	$data2file = getData();// получаем данные с клиента, упакованные в валидную строку с разделителями
	if(!$data2file) $error = 'Не удалось добавить статью в файл. Обратитесь к администратору.';
	
	addDataToFile($data2file, $path);

	$_SESSION['ok'] = 'ok';// выводим сообщение об успешной записи в файл
	header('Location: index.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Добавить статью</title>
    <style>
body { font-family: Georgia; font-size: 14px; color: #000; }

.red   { border: 3px solid red; } 		/* подсветка незаполненных полей */
.alert { color: red; } 					/* звездочки */

a { color: #00f; text-decoration: none; }
	a:hover { text-decoration: underline; }

textarea { width: 500px; height: 300px; }

.textarea-new-article-author 		{ width: 500px;	height: 60px;  }
.textarea-new-article-article-name	{ width: 500px; height: 100px; }
.input-new-article-category 		{ width: 200px; margin-right: 50px}
.input-new-article-year 			{ width: 50px;  margin-right: 50px}
.input-new-article-status 			{ width: 200px; margin-right: 50px}
.input-new-article-filename 		{ width: 333;   margin-right: 50px}
.input-new-article-pages 			{ width: 175;   margin-right: 50px}
.input-new-article-notes 			{ width: 719;   margin-right: 50px}
.input-new-article-iser_id 			{ width: 230;   margin-right: 50px}
    </style>
</head> 

<body>
<?php
/*
echo '<pre>'; print_r($_POST); echo '</pre>';
echo '<pre>'; print_r($_GET); echo '</pre>';
echo '<pre>'; print_r($_SESSION); echo '</pre>';
*/
?>
	<h1>Добавление статьи</h1>


	<? if($error) :?>
		<b style="color: red;">$error</b>
	<? endif ?>

	<?php
	// пришли на страницу методом ГЕТ, с помощью редиректа
	if(  isset($_SESSION['ok']) )
	{
		echo "<b style='color: green;'>Статья успешно добавлена в файл!</b>";
		unset($_SESSION['ok']);// если еще раз зайдем методом ГЕТ, то сессия уже будет чистая
	}
	?>
	
	<!-- форма для создания статьи -->
	<form action="" method="post" name="main_form" id="f">

		Автор		<span class="alert">*</span>:	<br/><textarea 	class="textarea-new-article-author 		  checkValue"	name="author"		></textarea>		<br/><br/>
		Название	<span class="alert">*</span>:	<br/><textarea 	class="textarea-new-article-article-name  checkValue"	name="article_name"	></textarea>	<br/><br/><br/>
		
		Категория	<span class="alert">*</span>:	<input class="input-new-article-category checkValue" 	  type="text" name="category"	  value="" 	/>
		Год			<span class="alert">*</span>:	<input class="input-new-article-year  	 checkValue" 	  type="text" name="year"  		  value="" 	/>
		Статус		<span class="alert">*</span>:	<input class="input-new-article-status   checkValue" 	  type="text" name="status"  	  value="" 	/>
		<br/>
		<br/>		
		Имя файла 	<span class="alert">*</span>:	<input class="input-new-article-filename checkValue" 	  type="text" name="file_name"    value="" 	/>
		Страницы 	<span class="alert">*</span>:	<input class="input-new-article-pages 	 checkValue"   	  type="text" name="article_page" value="" 	/>
		<br/>
		<br/>
		Примечания 	<span class="alert">*</span>:<br/><input class="input-new-article-notes checkValue" type="text" name="notes"  	  value="" 	/>
		<br/>
		<br/>
		<br/>
		<input type="submit" name="add_art" value="Добавить" />
	</form>

	<hr/>
</body>
</html>

<script>
// коллекция заполняемых полей
var btns = document.querySelectorAll('.checkValue');

// проверка заполнения полей
function checkFormFields() {

	var error = false;

	for(var i = 0; i < btns.length; i++){
		btns[i].classList.remove('red');	// снимаем предыдущее выделение
		
		if (!btns[i].value){
			btns[i].classList.add('red');	// выделяем пустой элемент
			error = true;
		}
	}

	if(error) return false;
	return true;
}

// обработка клика по кнопке отправки
document.querySelector('#f').onsubmit = function(e) {

	e.preventDefault();

	if (!checkFormFields()) {
		alert('Необходимо заполнить все поля формы!');
		return;
	}

	e.target.submit();
}
</script>