function askDialog(){
	
	var _this = null;
	var config

	this.open(configuration){
		_this = this;
		_this.config = configuration;
		_this.ini();
		$("#askDialog").dialog({
	        title:_this.config.title,
	        modal:true,
	        width:400,
	        height:250,
	        resizable:false,
	        buttons: {
	            _this.config.buttons
	            }
	        }
	    });
	}

	this.ini = function(){
		_this.generateHTML();
	}

	this.generateHTML = function(){
		var html = "<div id='askDialog'>";
		html += "<span>"+_this.config.msg+"</span>";
		html += "</div>";
		$('body').append(html);
	}

}