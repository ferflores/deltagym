function PagoServicio(){

	var _this = null;
	this.currentImgName = "";
	this.loadingImage = false;

	this.ini = function(){
		_this = this;
		_this.bindEvents();
	}

	this.bindEvents = function(){
		$(window).keydown(function(e) {
		    if (e.keyCode == 13) {
		        _this.buildPago();
		    }
			});

		$("#saveButton").button().on("click",function(){
			_this.buildPago();
		});

		_this.addValidations();
	}


	this.addValidations = function(){
		$("#txtMonto").attr("regex",new commonRegex().requiredNumberLength5);
	}

	this.validateData = function(){
		var validData = validateFields("tablaPagoServicios","field");

		if(parseInt($("#selectServicios").val())<1){
			validData = false;
			appendError($("#selectServicios"),"Es necesario seleccionar un servicio");
			$("#selectServicios").css("background-color","#F0DA95");
		}else{
			removeError($("#selectServicios"));
			$("#selectServicios").css("background-color","#F4F4F4");
		}
		return validData;
	}

	this.buildPago = function(){
		if(_this.validateData()){
			var date = getCurrentUTCDate();
			var newPagoServicio = { 
				pago:{
					idservicio: $("#selectServicios").val(),
					monto: $("#txtMonto").val(),
					comentario: $("#txtComentario").val()
				}
			}

			var ajaxConfiguration = {
				data:newPagoServicio,
				URL:"pagarServicio",
				callBack:_this.afterSave,
				async:true,
				showLoading:true
			}

			new AjaxRequest().request(ajaxConfiguration);
			}
	}

	this.afterSave = function(response){
		_this.clearForm();
		if(response>0){
			showMsg("Pago registrado!");
		}else{
			showMsg("El pago no pudo ser registrado!");
		}
	}

	this.clearForm = function(){
		$(".field").val("");
		$("#selectServicios option[value=-1]").attr('selected', 'selected');
	}

}