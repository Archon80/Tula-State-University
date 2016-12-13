<?php
/*
	ЕДИНАЯ ТОЧКА ВХОДА
*/

// переключение отладочного режима
$GLOBALS['DEBUG_MODE'] = true;

// автоподключение файлов из модели (условие работы: файл и класс д.б. одноименными)
function __autoload($classname)
{
	include_once("core/$classname.class.php");// имя вызываемого класса передается параметром
}

// в зависимости от гет-параметра страницы вызываем одноименный метод
function createPageName()
{
	// здесь формируется строка (название страницы): create_index, create_edit и т.п.
	// одноименные функции лежат в классе C_PAGE
	$temp = isset($_GET['id']) ? $_GET['id'] : 'index';
	return 'create_' . $temp;
}

// для разных сущностей в будущем
if(isset($_GET['c'])){
	switch ($_GET['c']) {
		case 'articles':
			$wizard = new C_Article();
			break;

		case 'page':
			$wizard = new C_Page();
			break;
		
		default:
			$wizard = new C_Page();
			break;
	}
}

////////////////////////////////////////////////////////////////////////////////////////

$wizard = new C_Page();			// формируем экземпляр страницы
$wizard->Request(createPageName());


















/*
ВЫБОРОЧНО добавить сайд-бар на НЕКОТОРЫХ страницах
--------------------------------------------------
	1. В базовом шаблоне верстки вставить элементы верстки и вывод поля: <div id="left-bar"><?=$left_sidebar?></div>
	2. В классе C_Site добавить стандартную модульную вставку: поле protected $left_sidebar	= '';
	3. В классе C_Site в методе renderTotalPage добавить элемент массива: 'left_sidebar' => $this->left_sidebar
	4. В классе C_Page в методе, который создает страницу с данным левым сайд-баром,
	   добавить формирование соотв. поля: $this->left_sidebar = $this->baseTemplating( 'views/test_left.html' );
	5. Profit!
*/