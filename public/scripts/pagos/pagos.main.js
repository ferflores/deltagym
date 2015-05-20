function Pago(){
	_this = null;
	var globalData = null;
	var socioInfo = null;

	this.ini = function(globalData){
		_this = this;
		_this.globalData = globalData;
		_this.bindEvents();
		_this.fillPagos(globalData.tiposDePago);
		_this.showUserSelector();
	}

	this.fillPagos = function(tiposDePago){
		for(var x=0;x<tiposDePago.length;x++){
			$("#selectTipoDePago").append("<option value=" + tiposDePago[x].id + ">" + tiposDePago[x].nombre + "</option>" );
		}
	}

	this.fillPromos = function(promos){
		$("#selectPromo").empty();
		$("#selectPromo").append("<option value='-1'></option>");
		if(promos.length>0){
			for(var x=0;x<promos.length;x++){
				$("#selectPromo").append("<option value=" + promos[x].id + ">" + promos[x].nombre + "</option>" );
			}
		}
	}

	this.bindEvents = function(){
		$("#selecOtro").button();
		$("#selecOtro").on("click",function(){
			window.location.assign("pago");
		});

		$("#selectTipoDePago").on("change",function(){
			var tipoId = $(this).val();
			if(tipoId<1){
				$("#selectPromo").empty();
				$("#txtTotal").val("");
			}else{
				var promos = $.grep(_this.globalData.promociones,function(a){
					return a.idtipodepago == tipoId
				});
				_this.fillPromos(promos);
				_this.showPrecio();
			}
		});

		$("#selectPromo").on("change",function(){
			_this.showPrecio();
		});

		$("#btnPagar").button().on("click",function(){
			_this.pagar();
		});
	}

	this.pagoRealizado = function(response){
		$("#pagos").remove();
		if(response<1){
			showMsg("Hubo un error, no se pudo registrar el pago");
		}else{
			var dialogConfig = {
				title:'Pago realizado',
				msg:'El pago ha sido realizado, desea realizar otro pago?',
				buttons: {
					Si: function(){
						window.location.assign("pago");
					},
					No: function(){
						window.location.assign("/");
					}
				}
			}

			new askDialog().open(dialogConfig);
		}
	}

	this.showPrecio = function(){
		var precio = _this.calcularPrecio();
		if(precio<1){
			$("#txtTotal").val("Error");
		}else{
			$("#txtTotal").val(precio);
		}
	}

	this.socioLoaded = function(socioData){
		_this.socioInfo = socioData;
		$("#pagos").show();
		$(".idSocio").html("0"+socioData.id);
		$(".nombreSocio").html(socioData.nombre);
		$(".apellidoPSocio").html(socioData.apellidop);
		$(".apellidoMSocio").html(socioData.apellidom);
		$(".emailSocio").html(socioData.email);
		$("#imgSocio").attr("src","php/sociosImg/"+socioData.imgname);
		$(".comentarioSocio").html(socioData.comentario);
		$(".categoriaSocio").html(_this.getNombreCategoria(socioData.idcategoria));
	}

	this.getNombreCategoria = function(idCategoria){
		var categoria = $.grep(_this.globalData.categorias,function(a){return a.id == idCategoria})[0];
		return categoria.nombre;
	}

	this.noUserSelected = function(){
		$("#pagos").remove();
		$("#noSocio").show();
		$("#selectUser").button();
		$("#selectUser").on("click",function(){
			window.location.assign("pago");
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

	this.calcularPrecio = function(){
		var tipoDePago = $("#selectTipoDePago").val();
		var promo = $("#selectPromo").val();
		var categoria = _this.socioInfo.idcategoria;
		var total = -1;
		
		if(promo>-1){
			var promoObj = $.grep(_this.globalData.promociones,function(a){
				return a.id == promo
			})[0];
			total = promoObj.costo;
		}else{
			var costo = $.grep(_this.globalData.costosDePago,function(a){
				return a.idcategoria == categoria && a.idtipodepago == tipoDePago
			});

			if(costo.length<1){
				showMsg("Error! no se encontró el precio");
			}else{
				total = costo[0].costo;
			}
		}

		return total;

	}

	this.pagar = function(){
		var total = $("#txtTotal").val();

			if(total.length>0 && total!="Error" && isNumber(total)){
				_this.verificarPromocionYStatus();
			}else{
				showMsg("Total no valido");
			}
	}

	this.verificarPromocionYStatus = function(){
		var dataToSend = {
				idsocio: _this.socioInfo.id,
				idpromo: $("#selectPromo").val()

				}
		var ajaxConfiguration = {
			data:dataToSend,
			URL:"verificarPromoYStatus",
			callBack:_this.verificarAplicacionPromocion,
			async:true,
			showLoading:true
		}
		new AjaxRequest().request(ajaxConfiguration);
	}

	this.verificarAplicacionPromocion = function(response){
		response = JSON.parse(response);
		if(response.promoFound>0){
			showMsg("La promoción seleccionada no puede ser aplicada mas de una vez al mismo socio");
		}else{
			if(response.ultimoPago==null){
				_this.realizarPago();
			}else{
				_this.validarUltimoPago(response);
			}
		}
	}

	this.validarUltimoPago = function(response){
		if(response.status == 'activo'){
			
			var nombreTipoDepago = $.grep(_this.globalData.tiposDePago,function(a){
				return a.id == response.ultimoPago.idtipodepago
			})[0].nombre;

			var proximoPago = response.ultimoPago.proximopago.split(" ")[0];

			var dialogConfig = {
				title:'Socio activo',
				msg:'El socio se encuentra activo actualmente, su último pago fue '
				+nombreTipoDepago+' y su próxima fecha de pago es: '
				+proximoPago+' desea continuar?',

				buttons: {
					Si: function(){
						$("#askDialog").dialog('close');
						_this.realizarPago();
					},
					No: function(){
						$("#askDialog").dialog('close');
					}
				}
			}

			new askDialog().open(dialogConfig);
		}else{
			_this.realizarPago();
		}
	}

	this.realizarPago = function(){
		var dataToSend = {
					pago: {
						idsocio: _this.socioInfo.id,
						idtipodepago: $("#selectTipoDePago").val(),
						monto: $("#txtTotal").val(),
					},
					promocion: {
						id: $("#selectPromo").val() > 0 ? parseInt($("#selectPromo").val()) : null
					}
				}
		var ajaxConfiguration = {
			data:dataToSend,
			URL:"addPago",
			callBack:_this.pagoRealizado,
			async:true,
			showLoading:true
		}

		new AjaxRequest().request(ajaxConfiguration);
	}

}

