/*
    Класс для отладки: вывод предупреждений и сообщений об ошибках

    Входные условия:
        1) подключение данного файла на необходимой странице (из папки public/js, например)
        2) наличие на странице подключения библиотеки jQuery (для AJAX-запросов)
        3) в корне проекта должен лежать файл error_log.php, исполняющий роль сервера (туда идут AJAX-запросы)
        4) в константе PATH_TO_SERVER должен быть прописан путь к этому php-файлу
 */
function Log() {
    
    // отладочный режим
    const DEBUG_LOG      = true;
    const PATH_TO_SERVER = "core/error_log.php";

    // фиксируем контекст объекта
    var that = this;

    // функции для проверок и отладки
    that.assert = function(cond, msg) {
        if(!cond){
            console.log( 'ОШИБКА!!! ' + msg );
            that.errorLog(msg);
        }
    }
    // обертка вокруг стандартного логгера
    that.rLog = function(param1, param2, param3) {
        if (DEBUG_LOG) { console.log(param1 ? param1 : '', param2 ? param2 : '', param3 ? param3 : ''); }
    }
    
    // вывод ошибок JS-са в файл! Необходим лежащий в корне проекта файл error_log.php
    that.errorLog = function(msg) {
        // проверки входного параметра
        if(!msg)                    { that.rLog( 'В функцию errorLog файла article_search.html не поступил параметр msg (текст сообщения об ошибке).' ); return; }
        if(typeof msg != 'string')  { that.rLog( 'В функцию errorLog файла article_search.html в качестве параметра msg поступила не строка.' );   return; }

        // вывод отладочной информации в консоль
        that.rLog( msg );

        // формирование объекта данных для отправки на сервер
        var dataToErrorLog = {"errorLog":msg};

        // отправка данных
        $.ajax({
            url         : PATH_TO_SERVER,            // адрес обработчика
            type        : "POST",                           // метод передачи данных
            timeout     : 5000,
            data        : dataToErrorLog,                   // отправляемые данные
            beforeSend  : function(){/* ... */},            // операции, которые выполнятся перед запросом
            success     : successErrorLog,
            error       : function(data) { console.log( "Ошибка логирования" ); },
            complete    : function(){/* ... */}             // операции, которые выполнятся gjckt pfghjcf
        });

        // вывод в консоль ответа сервера после записи сообщения об ошибке в файл
        function successErrorLog(data) {
            that.rLog( data );
        }
    }
}