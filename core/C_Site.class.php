<?php
/*
	базовый контроллер САЙТА:
		предназначен для действий, ОБЩИХ ДЛЯ ВСЕХ СТРАНИЦ САЙТА (вьюхи-модули, авторизация, навигация)
*/
abstract class C_Site extends C_Base
{
	// формирование переменных для вставок
	protected $meta				= '';		// мета-информация
	protected $header			= '';		// хедер
	protected $bread_crumbs		= '';		// навигационная цепочка
	protected $right_sidebar	= '';		// правая колонка		//protected $left_sidebar	    = '';		// левая (тестовая) колонка
	public $footer			= '';		// футер
	
	protected $content_inner	= '';		// основное содержимое срабатывает

	// конструктор (первичная инициализация вставок-модулей)
	function __construct()
	{
		//M_dbConnect::connect();		// подключение к БД
		
		// устанавливаем кодировку
		header('Content-type: text/html; charset=utf-8');

		// выводим ошибки
		if($GLOBALS['DEBUG_MODE']){
			error_reporting(E_ALL | E_STRICT);

			ini_set('display_errors','On');
			ini_set('error_reporting', E_ALL | E_STRICT);
			ini_set('display_startup_errors', '1');
		}
	}
	
	// заключительная шаблонизация - общая для всех СТРАНИЦ
	public function renderTotalPage()
	{
		// в каждое поле массива вставляем верстку соответствующей модульной вставки
		$inserts = 	array(
						'meta'   			=> $this->meta,
						'header' 			=> $this->header,
						'bread_crumbs' 		=> $this->bread_crumbs,
						//'left_sidebar' 		=> $this->left_sidebar,
						'right_sidebar' 	=> $this->right_sidebar,
						'footer' 			=> $this->footer,
						'content_inner' 	=> $this->content_inner
					);	
		
		// вставляем вставки в шаблон главной страницы
		$totalPage = $this->baseTemplating('views/view_000.html', $inserts);
		
		// выводим в браузер готовую итоговую верстку главной страницы (со всеми подпихнутыми полями)
		echo $totalPage;
	}
	// пока что - неизвестно
	protected function before()
	{
		# code...
	}
}
