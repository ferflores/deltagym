function Main(){
	var _this = null;

	this.ini = function(){
		_this = this;

		document.addEventListener("DOMContentLoaded", function(event) {
		var ajaxConfiguration = {
			data:{},
			URL:"getClassesToRemove",
			callBack:Main.removeClasses,
			async:true,
			showLoading:false
		}
		new AjaxRequest().request(ajaxConfiguration);
		});
	}
}

Main.classesToRemove = new Array();

Main.removeDOMElementsByClasses = function(){
		$.each(Main.classesToRemove,function(i,e){
			$(e).remove();
		});
}

Main.removeClasses = function(classes){
	if (classes!=-1) {
		var parsedClasses = JSON.parse(classes);
		Main.classesToRemove = parsedClasses;
		Main.removeDOMElementsByClasses();
	}
}

new Main().ini();

