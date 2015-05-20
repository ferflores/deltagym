function EmpleadoSelector(){
	var _this = null;
	this.config = null;
	this.loading = false;

	this.ini = function(config){
		_this = this;
		this.config = config;
		_this.loadResults("");
	}

	this.bindEvents = function(){
		$("#empleadoSelector #txtNombre").on("keydown",function(e){
			if(e.keyCode == 13){
				_this.loadResults($("#empleadoSelector #txtNombre").val());
			}
		});
	}

	this.bindTDEvents = function(){
		$(".empleadoSelectorTable td").on("click",function(e){
			var element = $(e.target).parent();
			var empleado = {
				id: element.find(".empleadoid").html(),
				nombre: element.find(".nombre").html(),
				apellidop: element.find(".apellidop").html(),
				apellidom: element.find(".apellidom").html(),
				email: element.find(".email").html(),
				imgname: element.find(".imgname").html(),
				comentario: element.find(".comentario").html()
			}

			if(_this.config.callBack!=null){
				_this.config.callBack(empleado);
			}

			$("#empleadoSelector").dialog("close");

		});
	}

	this.open = function(){
		$('body').append(_this.getHTML());
		$("#empleadoSelector").dialog({
	        title:'Seleccione un empleado',
	        modal:true,
	        width:600,
	        height:550,
	        resizable:false,
	        buttons: {
	            Cancelar: function(){
	            	if(_this.config.cancelCallBack!=null){
	            		_this.config.cancelCallBack();
	            	}
	                $(this).dialog("close");
	            }
	        }
	    });

	    _this.bindEvents();
	}

	this.getHTML = function(){
		$('#empleadoSelector').remove();
		var html = "<div id='empleadoSelector' style='display:none'>";
		html += "<div>";
		html += "<table>";
		html += "<tr>";
		html += "<td><span>Buscar nombre:</span></td>";
		html += "<td><input id='txtNombre' type='text'/> </td>";
		html += "<td><img id='loadingImg' src='img/default/loading.gif' style='display:none'/> </td>";
		html += "</tr>";
		html += "</table>";
		html += "</div>";
		html += "<div id='results'>";
		html += "</div>";
		html += "</div>";
		return html;
	}

	this.loadResults = function(nombre){
		if(!_this.loading){
			_this.loading = true;
			$('#txtNombre').attr('readonly', true);
			$("#loadingImg").show();
			var data = {nombre:$.trim(nombre)};
			var ajaxConfiguration = {
						data:data,
						URL:_this.config.actionURL,
						callBack:_this.showResults,
						async:true,
						showLoading:false
					}

			new AjaxRequest().request(ajaxConfiguration);
		}
	}

	this.showResults = function(response){
		$('#empleadoSelector #results').empty();
		$("#loadingImg").hide();
		$('#txtNombre').attr('readonly', false);
		var resp = JSON.parse(response);
		var html = "<table class='empleadoSelectorTable'>";
		html += "<thead>";
		html += "<tr>";
		html += "<th>Id</th>";
		html += "<th>Nombre</th>";
		html += "<th>Apellido P</th>";
		html += "<th>Apellido M</th>";
		html += "<th>Email</th>";
		html += "<th style='display:none'>Imagen</th>";
		html += "</tr>";
		html += "</thead>";

		for(var x=0 ; x<resp.Records.length;x++){
			html+= "<tr>";
			html += "<td class='empleadoid'>" + resp.Records[x].id + "</td>";
			html += "<td class='nombre'>" + resp.Records[x].nombre + "</td>";
			html += "<td class='apellidop'>" + resp.Records[x].apellidop + "</td>";
			html += "<td class='apellidom'>" + resp.Records[x].apellidom + "</td>";
			html += "<td class='email'>" + resp.Records[x].email + "</td>";
			html += "<td class='imgname' style='display:none'>" + resp.Records[x].imgname + "</td>";
			html += "<td class='comentario' style='display:none'>" + resp.Records[x].comentario + "</td>";
			html += "</tr>";
		}

		html += "</table>";

		$('#empleadoSelector #results').append(html);
		_this.loading = false;
		_this.bindTDEvents();
	}

	this.truncValue = function(value,max){
		if(value.length>max){
			value = value.substring(0,(max-3))+"...";
		}

		return value
	}

}