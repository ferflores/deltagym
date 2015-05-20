function PagoEmpleado(){
	var _this = null;
	var empleadoInfo = null;

	this.ini = function(){
		_this = this;
		_this.bindEvents();
		_this.showEmpleadoSelector();
	}

	this.bindEvents = function(){
		$("#selecOtro").button();
		$("#selecOtro").on("click",function(){
			window.location.assign("pagarEmpleadoView");
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
						window.location.assign("pagarEmpleadoView");
					},
					No: function(){
						window.location.assign("/");
					}
				}
			}

			new askDialog().open(dialogConfig);
		}
	}


	this.empleadoLoaded = function(empleadoData){
		_this.empleadoInfo = empleadoData;
		$("#pagos").show();
		$(".idEmpleado").html("0"+empleadoData.id);
		$(".nombreSocio").html(empleadoData.nombre);
		$(".apellidoPSocio").html(empleadoData.apellidop);
		$(".apellidoMSocio").html(empleadoData.apellidom);
		$(".emailSocio").html(empleadoData.email);
		$("#imgEmpleado").attr("src","php/sociosImg/"+empleadoData.imgname);
		$(".comentarioSocio").html(empleadoData.comentario);
	}

	this.noEmpleadoSelected = function(){
		$("#pagos").remove();
		$("#noEmpleado").show();
		$("#selecEmpleado").button();
		$("#selecEmpleado").on("click",function(){
			window.location.assign("pagoEmpleadoView");
		});
	}

	this.showEmpleadoSelector = function(){
		var config = {
			actionURL: 'getEmpleadosPorNombre',
			callBack: _this.empleadoLoaded,
			cancelCallBack: _this.noEmpleadoSelected
		}
		var empleado = new EmpleadoSelector();
		empleado.ini(config);
		empleado.open();
	}


	this.pagar = function(){
		var total = $("#txtTotal").val();

		if(total.length>0 && total!="Error" && isNumber(total)){
			_this.realizarPago();
		}else{
			showMsg("Total no valido");
		}
	}

	this.realizarPago = function(){
		var dataToSend = {
					pago: {
						idempleado: _this.empleadoInfo.id,
						monto: $("#txtTotal").val(),
						comentario: $("#txtComentario").val()
					}
				}
		var ajaxConfiguration = {
			data:dataToSend,
			URL:"pagarEmpleado",
			callBack:_this.pagoRealizado,
			async:true,
			showLoading:true
		}

		new AjaxRequest().request(ajaxConfiguration);
	}

}

