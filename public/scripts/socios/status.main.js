function Status(){
	var _this = null;
	var socioInfo = null;
	var globalData = null;

	this.ini = function(globalData){
		_this = this;
		_this.globalData = globalData;
		_this.bindEvents();
		if(typeof(globalData.socioId) == 'undefined'){
			_this.showUserSelector();
		}else{
			_this.socioLoaded(globalData.socioData.socioData);
		}
	}

	this.bindEvents = function(){
		$("#selecOtro").button();
		$("#selecOtro").on("click",function(){
			window.location.assign("status");
		});
	}

	this.showUserSelector = function(){
		var config = {
			actionURL: 'getUsuariosPorNombre',
			callBack: _this.socioLoaded,
			cancelCallBack: _this.noUserSelected
		}
		var user = new UserSelector();
		user.ini(config);
		user.open();
	}

	this.socioLoaded = function(socioData){
		_this.socioInfo = socioData;
		$(".idSocio").html("0"+socioData.id);
		$(".nombreSocio").html(socioData.nombre);
		$(".apellidoPSocio").html(socioData.apellidop);
		$(".apellidoMSocio").html(socioData.apellidom);
		$(".emailSocio").html(socioData.email);
		$("#imgSocio").attr("src","php/sociosImg/"+socioData.imgname);
		$(".comentarioSocio").html(socioData.comentario);
		$(".categoriaSocio").html(_this.getNombreCategoria(socioData.idcategoria));

		_this.getStatus();
		
	}

	this.getStatus = function(){
		var dataToSend = {
				idsocio: _this.socioInfo.id
			}

		var ajaxConfiguration = {
			data:dataToSend,
			URL:"statusSocio",
			callBack:_this.statusCargado,
			async:true,
			showLoading:true
		}
		new AjaxRequest().request(ajaxConfiguration);
	}

	this.statusCargado = function(response){
		response = JSON.parse(response);
		_this.handleStatus(response.status);
		_this.handleUltimoPago(response.ultimoPago);
		_this.handleUltimosPagos(response.ultimosPagos);
		$("#status").show();
	}

	this.handleStatus = function(status){
		$("#txtStatus").css("color","#"+status.color);
		$("#txtStatus").html(status.estatus);
		if(status.estatus == 'SIN PAGAR'){
			$("#proxPagoLabel").html("Debió pagar en:");
		}

		if(status.estatus == 'SIN PAGOS REGISTRADOS'){
			$("#ultimosPagos").remove();
			$("#proxPagoLabel").remove();
		}
		if(status.estatus == 'INACTIVO'){
			$("#proxPagoLabel").html("Debió pagar en:");
		}
	}

	this.handleUltimoPago = function(ultimoPago){
		if(ultimoPago!=null){
			var date = new Date(ultimoPago.proximopago + " UTC");
	        var dateSplit = date.toString().split(" ");
	        var dateString = dateSplit[1] + " " + dateSplit[2] + " " + dateSplit[3];

			$("#proximoPago").html(dateString);
		}
	}

	this.handleUltimosPagos = function(ultimosPagos){
		if(ultimosPagos.length>0){
			var html = _this.buildUltimosPagosTable(ultimosPagos);
			$("#ultimosPagos").empty();
			$("#ultimosPagos").append(html);
		}
	}

	this.buildUltimosPagosTable = function(ultimosPagos){
		var html = "<table style='border:1px dashed #666'>";
		html += "<caption style='text-align:left'>Últimos pagos:</caption>";
		html += "<thead style='background:#ADADAA'>";
		html += "<tr>";
		html += "<td style='border:1px dashed #666;padding:3px;text-align:center'>Tipo</td>";
		html += "<td style='border:1px dashed #666;padding:3px;text-align:center'>Fecha</td>";
		html += "<td style='border:1px dashed #666;padding:3px;text-align:center'>Monto</td>";
		html += "<td style='border:1px dashed #666;padding:3px;text-align:center'>Promoción</td>";
		html += "</tr>";
		html += "</thead>";

		for(var x=0;x<ultimosPagos.length;x++){
			var nombreTipoDepago = $.grep(_this.globalData.tiposDePago,function(a){
				return a.id == ultimosPagos[x].idtipodepago
			})[0].nombre;

			var nombrePromocion = '-';
			if(ultimosPagos[x].promo>0){
				nombrePromocion = $.grep(_this.globalData.promociones,function(a){
								return a.id == ultimosPagos[x].promo
							})[0].nombre;
			}

			var date = new Date(ultimosPagos[x].fecha + " UTC");
	        var dateSplit = date.toString().split(" ");
	        var dateString = dateSplit[1] + " " + dateSplit[2] + " " + dateSplit[3];

			html += "<tr>";
			html += "<td class='formTableTD' style='border:1px dashed #666;padding:3px;text-align:center'>" + nombreTipoDepago + "</td>"
			html += "<td class='formTableTD' style='border:1px dashed #666;padding:3px;text-align:center'>" + dateString + "</td>"
			html += "<td class='formTableTD' style='border:1px dashed #666;padding:3px;text-align:center'>" + ultimosPagos[x].monto + "</td>"
			html += "<td class='formTableTD' style='border:1px dashed #666;padding:3px;text-align:center'>" + nombrePromocion + "</td>"
			html += "</tr>";
		}

		html += "</table>";

		return html;
	}

	this.noUserSelected = function(){
		$("#status").remove();
		$("#noSocio").show();
		$("#selectUser").button();
		$("#selectUser").on("click",function(){
			window.location.assign("status");
		});
	}

	this.getNombreCategoria = function(idCategoria){
		var categoria = $.grep(_this.globalData.categorias,function(a){return a.id == idCategoria})[0];
		return categoria.nombre;
	}
}