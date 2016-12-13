/*
	Класс для поиска страниц из БД по АПИ
*/
function Server(){
	
	// переменные сценария
	var 
	    statusErrorDiv    = $('.status-error-div'),
	    statusOkDiv       = $('.status-ok-div'),
	    wrapOfTemplateDiv = document.querySelector('.all-templates'),
	    templateDiv       = document.querySelector('.wrap-arts-row'),
	    mainTable         = document.querySelector('.main-table');

    // диагностика верстки
    this.checkHTML = function() {
    	// поля формы
    	var that = this;
    	var cnt = true;

    	function sayError(str) {
    		console.log(str);
	        that.log(str);
	        cnt = false;
    	}

    	if(!$){
	        console.log('ОШИБКА!!! Не подключена библиотека jQuery');
    		//
    	}

    	if(!document.querySelector('.search-author-field')){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "search-author-field" (поле для ввода имени автора)');
	    }
	    if(!document.querySelector('.search-article-name-field')) {
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "search-article-name-field"  - поле для ввода названия статьи');
	    }
	    if(!document.querySelector('.search-category-list')){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "search-category-list" (поле для ввода категории статьи)');
	    }
	    if(!document.querySelector('.search-years-list')){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "search-years-list" (поле для ввода года публикации статьи)');
	    }

	    // кнопка отправки данных
	    if(!document.querySelector('.search-data-send')){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс ".search-data-send" (кнопка для отправки данных)');
	    }

	    // класс для работы функции проверки заполнения полей формы
	    var checked = document.querySelectorAll('.checkValue');
	    if(!checked){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "checkValue", необходимый для клиентской проверки заполнения полей формы');
	    }
	    if(checked.length != 4){
	       sayError('ОШИБКА!!! Не все поля для ввода данных имеют класс "checkValue", необходимый для клиентской проверки заполнения полей формы');
	    }

	    // скрытый блок, содержащий шаблоны для клонирования
	    if(!wrapOfTemplateDiv){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "all-templates" (скрытый див, хранящий шаблоны для клонирования)');
	    }
	    if(!wrapOfTemplateDiv.classList.contains('hide')){
	        sayError('ОШИБКА!!! В верстке не скрыт див, хранящий шаблоны для клонирования (он не имеет класса hide))');
	    }
	    // блок для клонирования строки под очередную запись из БД
	    if(!templateDiv){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс "wrap-arts-row" (див-шаблон для клонирования под каждую строку таблицы записей)');
	    }
	    // заготовка таблицы, которая изначально скрыта, а потом делается видимой
	    if(!mainTable){
	        sayError('ОШИБКА!!! В верстке страницы отсутствует класс ".main-table" (изначально скрытая таблица результатов)');
	    }
	    if(mainTable){
	    	if(!mainTable.classList.contains('hide')){
		        sayError('ОШИБКА!!! В верстке не скрыта таблица для вывода результатов');
		    }
	    }

	    return cnt;
    }

    function clearFields() {
    	statusErrorDiv.html('');
	    statusOkDiv.html('');
	    mainTable.classList.add('hide');
    }

    // разновидность проверки: должно быть заполнено хотя бы одно поле
	function checkFormFields() {
		var cnt = 0;

		$('.checkValue').each(function() {	// если не подключена jQuery, реализовать на JS
			if (!this.value) cnt++;
		});

		if(cnt == 4) return false;
		return true;
	}

	// возвращает объект с данными формы (каждый раз прописывается индивидуально)
	function getFormData() {
		return {
			"YBS" : {
				"searchAuthor"  : document.querySelector('.search-author-field').value,
				"searchArticle"	: document.querySelector('.search-article-name-field').value,
				"searchCategory": document.querySelector('.search-category-list').value,
				"searchYear"	: document.querySelector('.search-years-list').value
			}
		}
	}

	/*
		Типовая функция проверки объекта на валидность
			блок предварительных подготовлений
					- заготовки возвращаемого объекта (по дефолту - статус false, и data - пустая строка)
					- шаблон текста ошибки
					- мини-функция для определения длины
			блок обработки возможных исключений (начало try)
			блок положительного исхода    (окончание try - если ни одно исключения не было выброшено)
			блок обработки ошибок         (catch: пишем текст выброшенной ошибки в раздел data возвращаемого объекта)
			блок завершения               (возвращаем объект с двумя полями: статус и тело)

	*/
    function checkDataToServer(arr){
	    // возвращаемый из функции массив
	    res = {
	        'status' : false,
	        'data'   : ''
	    };
	    err = 'ERROR [ Server::checkDataToServer ] - ';

	    function getLength(o) {
	        var cnt = 0;
	        for(i in o) cnt++;
	        return cnt;
	    }
	    //console.log('11111 ', getLength(arr), arr);

	    try {
	        // проверки целостности программы: предварительно тестируем сам входной массив
	        if(!arr){
	            throw new Error(err + 'не поступил параметр');
	        }
	        if(typeof arr !== 'object'){
	            throw new Error(err + 'в качестве основного параметра поступил не массив.');
	        }
	        if(getLength(arr) == 0){
	            throw new Error(err + 'в качестве основного параметра поступил пустой массив.');
	        }
	        if(getLength(arr) != 4){// проверяем заранее количество элементов поступившего массива
	            throw new Error(err + 'в качестве основного параметра поступил не валидный массив массив (число элементов не равно 4).');
	        }

	        // проверяем 1-ый элемент массива - имя автора
	        if( !('searchAuthor' in arr) ){
	            throw new Error(err + 'поступил не валидный массив (отсутствует поле "searchAuthor"');
	        }
	        if(typeof arr['searchAuthor'] != 'string' ){
	            throw new Error(err + ' в качестве имени автора (поле searchAuthor) передана не строка.');// для цифр - свой тип данных, и т.п.
	        }
	        // проверяем 2-ый элемент массива - название статьи
	        if( !('searchArticle' in arr) ){
	            throw new Error(err + 'поступил не валидный массив (отсутствует поле "searchArticle"');
	        }
	        if(typeof arr['searchArticle'] != 'string' ){
	            throw new Error(err + ' в качестве названия строки (поле searchArticle) передана не строка.');// для цифр - свой тип данных, и т.п.
	        }
	        // проверяем 3-ый элемент массива - категория статьи
	        if( !('searchCategory' in arr) ){
	            throw new Error(err + 'поступил не валидный массив (отсутствует поле "searchCategory"');
	        }
	        if(typeof arr['searchCategory'] != 'string' ){
	            throw new Error(err + ' в качестве названия категории (поле searchCategory) передана не строка.');// для цифр - свой тип данных, и т.п.
	        }
	        // проверяем 4-ый элемент массива - год выхода статьи
	        if( !('searchYear' in arr) ){
	            throw new Error(err + 'поступил не валидный массив (отсутствует поле "searchYear"');
	        }
	        if(typeof arr['searchYear'] != 'string' ){
	            throw new Error(err + ' в качестве года выхода статьи (поле searchYear) передана не строка.');// для цифр - свой тип данных, и т.п.
	        }

	        // если же все успешно
	        res['status'] = true;
	    }
	    catch(err){
	        res['data'] = err.message;
	    }
	    finally {
	        return res;
	    }    
    }// checkDataToServer
    
    // функция для отправки запроса (обертка вокруг метода jQuery)
	function sendQuery(data, cbSuccess, cbError) {
		// посылаем запрос
	    $.ajax({
	        url     	: 'core/client_api_viewer.php',		// адрес обработчика
	        type    	: 'POST',							// метод передачи данных
	        timeout 	: 5000,
	        data    	: data,								// отправляемые данные
            beforeSend  : function(){/* ... */},			// операции, которые выполнятся перед запросом
	        success 	: function(data) { cbSuccess(data) },
	        error   	: function(data) { cbError(data); },
	        complete 	: function(){/* ... */}				// операции, которые выполнятся gjckt pfghjcf
	    });
	}

	// обработка ошибки ответа сервера (стандартная нагугленная функция, не трогать ее)
	function error(data, codeError) {
		if(codeError == 'parsererror'){
            statusErrorDiv.html('Возникла ошибка при получении данных с сервера! ('+codeError+')').css({'color':'red'});
		} else {
            statusErrorDiv.html('Сервер не отвечает! Код ошибки: '+data.status).css({'color':'red'});
		}
	}

	// обработка ответа сервера
	function success(serverAnswer) {
        //console.log('[ function success() ] Данные с сервера, свеженькие, с пылу с жару: ', serverAnswer);

        // проверка валидности пришедшего с сервера объекта
        parsedAnswer = checkDataFromServer(serverAnswer);
        if(!parsedAnswer['status']){
        	console.log('С сервера пришел некорректный ответ. Не удалось получить статьи. Вид ошибки - читай ниже.');
        	console.log(parsedAnswer['data']);
			showUserBadNews();
			return;
        }

        //console.log('Данные сервера после обработки в функции checkDataFromServer: ', parsedAnswer);

		// если пришел пустой объект
		if(parsedAnswer['data'].length == 0){
			console.log('С сервера пришел пустой объект, статей по данному запросу нет.');
			statusOkDiv.html('По данному запросу статей не обнаружено.');
			return;
		}

		// выводим данные на экран
		showDataFromServer(parsedAnswer['data']);
	}

	// проверяем данные, полученные с сервера
	function checkDataFromServer(serverAnswer) {
		// возвращаемый из функции массив
	    res = {
	        'status' : false,
	        'data'   : ''
	    };
	    err = 'ERROR [ Server::checkDataFromServer ] - ';

	    function getLength(o) {
	        var cnt = 0;
	        for(i in o) cnt++;
	        return cnt;
	    }

	    try {
	        // проверки целостности программы: предварительно тестируем входной параметр
	        if(!serverAnswer){
	            throw new Error(err + 'не поступил параметр');
	        }
	        if(typeof serverAnswer !== 'string'){
	            throw new Error(err + 'в качестве основного параметра поступила не строка || ' + serverAnswer);
	        }
	        if(serverAnswer.length == 0){
	            throw new Error(err + 'в качестве основного параметра поступила пустая строка || ' + serverAnswer);
	        }

	        try {// обрабатываем отдельным try-catch, т.к. функция JSON.parse выдает ошибку, если строка была не валидная
	            serverAnswer = JSON.parse(serverAnswer);
	        } catch (err){
	            throw err;
	        }

	        if(typeof serverAnswer != 'object' ){
	        	throw new Error(err + 'не удалось распарсить строку, которая пришла с сервера || ' + serverAnswer);
	        }

	        res['status'] = true;
	        res['data']   = serverAnswer;
	    }
	    catch(err){
	        res['data'] = err.message;
	    }
	    finally {
	        return res;
	    }
	} // checkDataFromServer

	// обрабатываем (выводим) данные, полученные с сервера
	function showDataFromServer(serverAnswer) {
		// вывод полученных с сервера данных на страницу
		$('.checkValue').each(function() {
			//this.value = '';							очистка полей формы
		});

		// делаем видимой таблицу вывода результатов
		mainTable.classList.remove('hide');

		// организуем цикл по числу статей из БД, на каждой итерации вставляем данные одной строки
		for(var i = 0; i < serverAnswer.length; i++){
			createOneRow(serverAnswer[i]);
		}
	}

	// обработка ответа сервера
	function createOneRow(arrData) {
		var currentTemplate = templateDiv.cloneNode(true);

		currentTemplate.children[0].innerHTML = arrData.author;
		currentTemplate.children[1].innerHTML = arrData.article_name;
		currentTemplate.children[2].innerHTML = arrData.category;
		currentTemplate.children[3].innerHTML = arrData.year;
		currentTemplate.children[4].innerHTML = arrData.status;
		currentTemplate.children[5].innerHTML = arrData.filename;
		currentTemplate.children[6].innerHTML = arrData.article_page;

		mainTable.appendChild(currentTemplate);
	}

	// показ сообщения пользователю о неудачной попытке получить статьи
	function showUserBadNews() {
		statusErrorDiv.html('Не удалось получить статьи. Сообщите об ошибке администратору.');
	}

	// показ сообщения пользователю о неудачной попытке получить статьи
	this.log = function(data) {
		var dataToErrorLog = {"article_search":data};

		// посылаем запрос
	    $.ajax({
	        url     	: 'core/error_log.php',				// адрес обработчика
	        type    	: 'POST',							// метод передачи данных
	        timeout 	: 5000,
	        data    	: dataToErrorLog,					// отправляемые данные
	        success 	: function(d) { logSuccess(d) },
	        error   	: function(d) { logError(d); },
	    });

	    function logSuccess(data) {
	    	//console.log(data);
	    	//if(data == '777') console.log('В файле логов ошибок появилась новая запись...');
	    }
	    function logError(data) {
	    	console.log(data);
	    	console.log('Не удалось записать данные ошибки в лог. Проверьте работу функции server.log');
	    }
	}

	
	// основная логика
	this.main = function() {
		// предварительная очистка всех полей, сокрытие следов, программа защиты свидетелей...
		console.log(start);
		if(!start) return;
		clearFields();

		//проверка заполнения полей формы		
		if( !checkFormFields() ){
			alert("Должно быть заполнено хотя бы одно поле!");
			return;
		}
		// получение объекта данных от пользователя
		var dataToServer = getFormData();
		
		// проверка валидности отправляемого на сервер объекта данных
		var check = checkDataToServer(dataToServer['YBS']);
		if(!check['status']){
			console.log('Не удалось подготовить пользовательские данные для отправки на сервер');												// для разработчиков
			console.log(check['data']);					// для разработчиков
			showUserBadNews();							// для клиентов
			return;
		}
		// отправка данных на сервер, обработка ответа сервера
		sendQuery(dataToServer, success, error);
	}
} // end of Server



/*
// диагностирование взаимодействия html-страницы и js-сценария 
var requiredCSS     = ['red', 'hide'];			// обязательные для работы сценария CSS-правила
var requiredClasses = ['checkValue', 'error'];	// обязательные для работы сценария классы
var enterTest 		= new EnterTest(requiredCSS, requiredClasses);

enterTest.main();
*/

// подключаем необходимые для работы классы
var Log    = new Log();
var server = new Server();

// проверяем валидность верстки
var start = server.checkHTML();
var startBtn = document.querySelector('.search-data-send');

// принимаем данные пользователя, шлем на сервер, выводим ответ сервера
if(start && startBtn){
	startBtn.onclick = function() { server.main(); }
}

