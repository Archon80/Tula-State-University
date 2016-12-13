var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();
// Конец определения версии браузера
// Пример запуска
//document.write('<p class="accent">You\'re using ' + BrowserDetect.browser + ' ' + BrowserDetect.version + ' on ' + BrowserDetect.OS + '!</p>'); 
// Ты используешь Chrome 40 on Windows!


if (BrowserDetect.browser == "Explorer") //  || BrowserDetect.browser == "Opera"
{
version_brows = "pdf/web/preview_ie.php";
href_begin = "<a href='#bottom' onclick=\"load_pdf_ie(\'";
href_end_1 = "');\" \>";
}
else
{
version_brows = "pdf/web/preview_therest_"+lang+".php";
href_begin = "<a href='#bottom' onclick=\"load_pdf_therest(\'";
href_end_1 = "');\" \>";
}

// функция загрузки данных для всех кроме IE
function load_pdf_therest(number_chast_vypuska)
{
window.open(version_brows + "?x=" + number_chast_vypuska, '_top');
}

// функция загрузки данных для IE
function load_pdf_ie(number_chast_vypuska)
{
 var myiframe = parent.document.getElementById('pdf_download');
 myiframe.src = "pdf/web/download_pdf.php" + "?x=" + number_chast_vypuska;
}
					
			function showhide(id_disp,god)
				{
					seriya = "pedagogics";
					
					icon = "<img src='images/pdf.jpg' border=0 class='td-space'> ";
					begin = "<td>" + icon + "</td><td>"; 
					begin_ziro = "<td></td><td>"; 
					end = "</td>";
										
					radelitel = "</tr><tr>";
					
					table_begin = "<table align=left class='tabl_pdf_page'><tr>";
					table_end = "</tr></table>";
					
					// Проверка на тип браузера
					// Если браузер не поддерживает показ PDF, то показываем ему ссылки напрямую
					// Сейчас ссылки и части кода закомментированы, т.к. они определяются ранее в блоке					
					//href_begin = "<a href='#' onclick=\"load_pdf_therest(\'";
					//href_end_1 = "');\" \>";
					
					href_end_2 = "</a>";

					if (god == "2014")
					{
					var technikal_2014 = new Array(); 
					technikal_2014[0] = table_begin;
					technikal_2014[1] = begin + href_begin + "tsu_izv_pedagogics_2014_01" + href_end_1 + " Выпуск 1"  + href_end_2 + end;
					technikal_2014[6] = begin_ziro + " " + end;
					technikal_2014[11] = begin_ziro + " " + end;
					technikal_2014[16] = begin_ziro + " " + end;
					technikal_2014[5] = radelitel;
					technikal_2014[2] = begin_ziro + " " + end;
					technikal_2014[7] = begin_ziro + " " + end;
					technikal_2014[12] = begin_ziro + " " + end;
					technikal_2014[17] = begin_ziro + " " + end;
					technikal_2014[10] = radelitel;
					technikal_2014[3] = begin_ziro + " " + end;
					technikal_2014[8] = begin_ziro + " " + end;
					technikal_2014[13] = begin_ziro + "" + end;
					technikal_2014[18] = begin_ziro + "" + end;
					technikal_2014[15] = radelitel;
					technikal_2014[4] = begin_ziro + " " + end;
					technikal_2014[9] = begin_ziro + " " + end;
					technikal_2014[14] = begin_ziro + "" + end;
					technikal_2014[19] = begin_ziro + "" + end;
					technikal_2014[20] = table_end;
					
					document.getElementById('oblojka').src = 'images/oblojka/' + seriya + '_' + god + '.jpg';
					document.getElementById('drop' + id_disp).style.display='inline'; 				
					// Вывод данных в зависимости от языка сайта
					// Если русский  2 варианта, переменной нет - старт сайта первый раз (язык по умолчанию), 2 - переход с англитйского на русский сайт
					if (lang == 'ru') { document.getElementById('drop' + id_disp).innerHTML = technikal_2014.join(""); }
					// Если английский идет примитивный автоматический перевод ссылок
					else {
					document.getElementById('drop' + id_disp).innerHTML = technikal_2014.join("").replace(new RegExp("Выпуск",'g'),"Issue")
					.replace(new RegExp("Спец",'g'),"Specials").replace(new RegExp("Часть",'g'),"Part").replace(new RegExp("выпуск",'g'),"issue");
					}
					}
					

if (god == "2015")
					{
					var technikal_2015 = new Array(); 
					technikal_2015[0] = table_begin;
					technikal_2015[1] = begin + href_begin + "tsu_izv_pedagogics_2015_01" + href_end_1 + " Выпуск 1"  + href_end_2 + end;
					technikal_2015[6] = begin_ziro + " " + end;
					technikal_2015[11] = begin_ziro + " " + end;
					technikal_2015[16] = begin_ziro + " " + end;
					technikal_2015[5] = radelitel;
					technikal_2015[2] = begin_ziro + " " + end;
					technikal_2015[7] = begin_ziro + " " + end;
					technikal_2015[12] = begin_ziro + " " + end;
					technikal_2015[17] = begin_ziro + " " + end;
					technikal_2015[10] = radelitel;
					technikal_2015[3] = begin_ziro + " " + end;
					technikal_2015[8] = begin_ziro + " " + end;
					technikal_2015[13] = begin_ziro + "" + end;
					technikal_2015[18] = begin_ziro + "" + end;
					technikal_2015[15] = radelitel;
					technikal_2015[4] = begin_ziro + " " + end;
					technikal_2015[9] = begin_ziro + " " + end;
					technikal_2015[14] = begin_ziro + "" + end;
					technikal_2015[19] = begin_ziro + "" + end;
					technikal_2015[20] = table_end;
					
					document.getElementById('oblojka').src = 'images/oblojka/' + seriya + '_' + god + '.jpg';
					document.getElementById('drop' + id_disp).style.display='inline'; 				
					// Вывод данных в зависимости от языка сайта
					// Если русский  2 варианта, переменной нет - старт сайта первый раз (язык по умолчанию), 2 - переход с англитйского на русский сайт
					if (lang == 'ru') { document.getElementById('drop' + id_disp).innerHTML = technikal_2015.join(""); }
					// Если английский идет примитивный автоматический перевод ссылок
					else {
					document.getElementById('drop' + id_disp).innerHTML = technikal_2015.join("").replace(new RegExp("Выпуск",'g'),"Issue")
					.replace(new RegExp("Спец",'g'),"Specials").replace(new RegExp("Часть",'g'),"Part").replace(new RegExp("выпуск",'g'),"issue");
					}
					}					
			
					 
				//	return false;
				}

				
function status_jurnal(status,year)
{
if(status == "архив") { a_1 = "<a href=\"#bottom\" class=\"hide\" onclick=\"showhide(31,'"; }
else { a_1 = "<a href=\"#bottom\" onclick=\"showhide(31,'"; }

a_2 = "');\">";
a_3 = "</a>";

return a = a_1 + year + a_2 + year + a_3;
}

function archive_jurnal_hide(status)
{
	var divs=document.getElementsByTagName("A");
	for( var i=0; i<divs.length; i++)
		{
		if(divs[i].className=="hide")
		divs[i].style.display='none';
		}
document.getElementById('arhiv_href').innerHTML = "<a href=\"#bottom\" id='arhiv_href' onclick=\"archive_jurnal_show('');\">Раскрыть архив</a>";
}

function archive_jurnal_show(status)
{
	var divs=document.getElementsByTagName("A");
	for( var i=0; i<divs.length; i++)
		{
		if(divs[i].className=="hide")
		divs[i].style.display='inline';
		}
document.getElementById('arhiv_href').innerHTML = "";
}
	
function jurnal()		
{
	var jurnal = new Array(); 
	jurnal[0] = status_jurnal("актуальный","2014");
	jurnal[1] = status_jurnal("актуальный","2015");
		
	document.getElementById('jurnal').style.display='inline'; 				
	if (lang == 'ru') { document.getElementById('jurnal').innerHTML = "<p><b>Полнотекстовые версии выпусков по годам издания: <a href=\"#bottom\" id='arhiv_href' onclick=\"archive_jurnal_show('');\">Архив</a> " + jurnal.join(" ") + "</b></p>"; }
	// Если английский идет примитивный автоматический перевод ссылок
	else {
	document.getElementById('jurnal').innerHTML = "<p><b>Full-text versions of issues by year of publication: <a href=\"#bottom\" id='arhiv_href' onclick=\"archive_jurnal_show('');\">Archive</a> " + jurnal.join(" ") + "</b></p>";
	}
}
