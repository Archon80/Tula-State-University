<?php
/*
	ЕДИНАЯ ТОЧКА ВХОДА
*/
$GLOBALS['DEBUG_MODE'] = true;

function __autoload($classname)
{
	include_once("core/$classname.class.php");// имя вызываемого класса передается параметром
}

function createPageName()
{
	$temp = isset($_GET['id']) ? $_GET['id'] : 'index';
	return 'create_' . $temp;
}

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

$wizard = new C_Page();
$wizard->Request(createPageName());
