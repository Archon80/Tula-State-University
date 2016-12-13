/**
 *  Сценарий для тестирования взаимодействия html-страницы и js-сценария
 *
 * 	Обязательные условия:
 * 		1 - подключена jQuery
 * 		2 - все проверяемые поля должны иметь класс checkValue
 * 		3 - CSS-классы: red, hide
 * 		4 - блоки с классами: checkValue, error
 */

function EnterTest(arrCSS, arrClasses) {
    
    // обязательные стилевые правила
    var requiredCSS      = arrCSS;    // CSS-селекторы, которые обязательно должны быть
    var requiredClasses  = arrClasses;// классы, которые обязательно должны быть
    var debugMode        = true;
    var allCSS           = '';        // все CSS-селекторы

    // проверяем наличие на странице элементов с классами, обязательными для работы сценария JavaScript
    // принимаем массив обязательных CSS-селекторов, и массив всех CSS-селекторов
    function checkAllClasses(arrRequiredClasses) {
        "use strict";

        if(!arrRequiredClasses) { alert('В функцию checkAllClasses не пришел 1-й параметр (массив всех селекторов CSS)');}
        if( !Array.isArray(arrRequiredClasses) ) { alert('В функцию checkAllClasses 1-ым параметром передан не массив');}

        // обходим циклом массив обязательных классов, каждый из них ищем в базе
        for(var i = 0; i < arrRequiredClasses.length; i++){
            if( !isContainOneClass( arrRequiredClasses[i]) ) {
                rLog('ОШИБКА!!! Обязательный класс '+arrRequiredClasses[i]+' не обнаружен!');
            }
        }
    }

    // проверяем наличие на странице CSS-селекторов, обязательных для работы сценария JavaScript
    // принимаем массив обязательных CSS-селекторов, и массив всех CSS-селекторов
    function checkAllCSS(arrRequiredCss, allCSS) {
        "use strict";

        if(!arrRequiredCss) { alert('В функцию checkAllCSS не пришел 1-й параметр (массив всех селекторов CSS)');}
        if( !Array.isArray(arrRequiredCss) ) { alert('В функцию checkAllCSS 1-ым параметром передан не массив');}

        if(!allCSS) { alert('В функцию checkAllCSS не пришел 2-й параметр (массив всех селекторов CSS)');}
        if( !Array.isArray(allCSS) ) { alert('В функцию checkAllCSS 2-ым параметром передан не массив');}

        // обходим циклом массив обязательных CSS-селекторов, каждый из них ищем в базе
        for(var i = 0; i < arrRequiredCss.length; i++){
            if( !isContainOneCSS(arrRequiredCss[i] ,allCSS) ) {
                rLog('ОШИБКА!!! Обязательный селектор '+arrRequiredCss[i]+' не обнаружен!');
            }
        }
    }

    // получение массива всех CSS-селекторов
    function checkJQuery() {
        if(!window.jQuery){ rLog('ОШИБКА! Библиотека jQuery не подключена'); }
    }

    // получение массива всех CSS-селекторов
    function getAllCSS() {
        var arrTemp = [].reduce.call(document.styleSheets,(p,e)=>p.concat([].map.call(e.cssRules,e=>e.selectorText)),[]);

        var arrTotal = [].map.call(arrTemp, function(elem, i, arr) {
            if(elem) return elem.slice(1);
        });

        return arrTotal;
    }

    // принимаем один обязательный класс (строку), и смотрим, содержится ли он в сценарии
    function isContainOneClass(currentClass) {
        "use strict";

        if(!currentClass) { alert('В функцию isContainOneClass не пришел 1-й параметр (название селектора CSS)');}
        if(typeof currentClass != 'string') { alert('В функцию isContainOneClass 1-ым параметром передана не строка');}

        var temp = document.querySelectorAll('.'+currentClass);// коллекция классов с таким именем

        if (temp.length) return true;                          // если не пустая - класс присутствует
        return false;
    }

    // принимаем один CSS-селектор (строку), и смотрим, содержится ли он в сценарии
    function isContainOneCSS(currentCSS, allCSS) {
        "use strict";

        if(!currentCSS) { alert('В функцию isOneCSS не пришел 1-й параметр (название селектора CSS)');}
        if(typeof currentCSS != 'string') { alert('В функцию isOneCSS 1-ым параметром передана не строка');}

        if(!allCSS) { alert('В функцию isOneCSS не пришел 2-й параметр (массив всех селекторов CSS)');}
        if( !Array.isArray(allCSS) ) { alert('В функцию isOneCSS 2-ым параметром передан не массив');}

        for(var i = 0; i < allCSS.length; i++){
            if(allCSS[i] == currentCSS) return true;
        }
        return false;
    }

    // собственный логгер
    function rLog(param1, param2, param3) {
        if (debugMode) { console.log(param1 ? param1 : '', param2 ? param2 : '', param3 ? param3 : ''); }
    }

    // основной метод программы, запускающий всю движуху
    this.main = function() {
        var allCSS = getAllCSS();           // получаем все CSS-селекторы страницы
        checkAllCSS(requiredCSS, allCSS);   // проверяем наличие обязательных CSS-селекторов страницы

        checkAllClasses(requiredClasses);   // проверяем наличие обязательных классов на странице
        checkJQuery();
        console.log('Диагностика закончена. Класс EnterTest закончил свою работу.');
    }
} // end of enterTest
