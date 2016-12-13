window.onload = function() {

	var scriptsPath = [
		
		//'js/list.js'
	];

	function createScriptJS(srcUrl) {
		var tempScript = document.createElement('script');
		tempScript.setAttribute('type', 'text/javascript');
		tempScript.setAttribute('src', srcUrl);
		document.getElementsByTagName('head')[0].appendChild(tempScript);
		
	};

	for(var i = 0, i_max = scriptsPath.length; i < i_max; i++){
		createScriptJS(scriptsPath[i]);
	}
}



