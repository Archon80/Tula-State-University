<?php
/*
	контроллер СТРАНИЦЫ
			предназначен для действий НА КОНКРЕТНОЙ СТРАНИЦЕ (при необходимости - переопределение базовых вставок и прочих сущностей)
			срабатывает автоподключение класса-родителя (в единой точке входа - файле index.php)
*/
class C_Page extends C_Site
{
	// конструктор - остается прежним (просто вызываем родительский)
	function __construct(){
		parent::__construct();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////   формируем вставки-"модули"   ////////////////////////////////////
	///////////////////////////   (идем по адресу и считываем верстку в соотв. поле класса) ///////
	///////////////////////////////////////////////////////////////////////////////////////////////
	private function createStandartModules()
	{
		$this->meta 			= $this->baseTemplating( 'views/meta.html' );
		$this->header 			= $this->baseTemplating( 'views/header.html');
		$this->bread_crumbs		= $this->baseTemplating( 'views/bread_crumbs.html' );
		$this->right_sidebar	= $this->baseTemplating( 'views/right_sidebar.html' );
		$this->footer 			= $this->baseTemplating( 'views/footer.html');
	}


	///////////////////////////////   "ОРГАНИЗАЦИОННЫЕ" СТРАНИЦЫ  //////////////////////////////////

	// страница поиска статей
	public function create_articles_search()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/articles_search.html');
	}

	// индексная страница
	public function create_index()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/index.html');
	}						

	// редакционный совет
	public function create_sovet()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/sovet.html');
	}

	// списки литературы
	public function create_list_of_literature()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/list_of_literature/list_of_literature.html');
	}
	
	
	/////////////////////////////////   "ТЕМАТИЧЕСКИЕ" СТРАНИЦЫ   //////////////////////////////////////
	
	// тематическая страницы сборника - НАУКИ О ЗЕМЛЕ
	public function create_earth()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/earth.html');
	}

	// тематическая страницы сборника - ЭКОНОМИЧЕСКИЕ науки
	public function create_economic()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/economic.html');
	}


	// тематическая страницы сборника - ГУМАНИТАРНЫЕ науки
	public function create_humanitarian()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/humanitarian.html');
	}


	// тематическая страницы сборника - ЕСТЕСТВЕННЫЕ науки
	public function create_natural()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/natural.html');
	}

	// тематическая страницы сборника - ПЕДАГОГИЧЕСКИЕ науки
	public function create_ped()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/ped.html');
	}

	// тематическая страницы сборника - ФИЗКУЛЬТУРА И СПОРТ
	public function create_sport()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/sport.html');
	}

	// тематическая страницы сборника - ТЕХНИЧЕСКИЕ науки
	public function create_technical()
	{
		$this->createStandartModules();
		$this->content_inner = $this->baseTemplating('views/pages/thematics/technical.html');
	}
/*
	// тестовая страница (пример добавления сайдбара на НЕКОТОРЫХ страницах)
	public function create_test()
	{
		$this->createStandartModules();
		$this->left_sidebar 	= $this->baseTemplating( 'views/test_left.html' );
		$this->content_inner = $this->baseTemplating('views/pages/thematics/sport.html');
	}
*/	
	//$this->rShow();
}
