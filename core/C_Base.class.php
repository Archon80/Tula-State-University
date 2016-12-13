<?php
/*
	ВСЕОБЩИЙ контроллер
		много полезных методов ОБЩЕГО назначения (типа на всех сайтах можно применить)
*/
abstract class C_Base
{
	// генерация внешнего шаблона (модульные вставки)
	//protected abstract function renderTotalPage();

	// 404
	public function __call($name, $params){
        $this->create_404();
	}

	// автоматическа шаблонизация (в подключаемый шаблон подпихиваем переданные в массиве переменные)
	protected function baseTemplating( $pathToFile, $vars = array() )
	{
		// из элементов массива формируем набор одноименных переменных для последующего подпихивания
		extract($vars);			// foreach ($vars as $k => $v) { $$k = $v; }

		// подключаем шаблон, в соотв. места которого будут подпихнуты сформированные переменные
		ob_start();					// старт буфферизации
		include "$pathToFile";		// подключение шаблона
		return ob_get_clean();		// окончание буфферизации и выводЫ
	}

	// обертка над всеми методами-шаблонизаторами
	public function Request($pageName)
	{
		$this->before();
		$this->$pageName();			// вызываем функцию страницы, чей id передали в гет-запросе (пишем в поля экземпляра модульные вставки)
		$this->renderTotalPage();		// рендерим шаблон основной страницы (подпихиваем модульные вставки в общий шаблон)
	}

	// страница поиска статей
	public function create_404()
	{
		$this->content_inner = $this->baseTemplating('views/404.html');
	}

	// проверки: каким способом обратились
	protected function IsGet() { return $_SERVER['REQUEST_METHOD'] == 'GET'; }
	protected function IsPost(){ return $_SERVER['REQUEST_METHOD'] == 'POST';}

	public function rShow($value='')
	{
		echo '<pre>';
		print_r($value);
		echo '</pre>';
	}
}
