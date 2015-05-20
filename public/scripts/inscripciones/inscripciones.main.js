function Inscripciones(){

	var _this = null;
	this.currentImgName = "";
	this.loadingImage = false;

	this.ini = function(){
		_this = this;
		$(".firstFocus").focus();
		$("#progressBar").progressbar({value:0});
		_this.bindEvents();
	}

	this.bindEvents = function(){
		$(window).keydown(function(e) {
		    if (e.keyCode == 13) {
		        _this.uploadImage(_this.buildSocio);
		    }
			});

		$("#saveButton").button().on("click",function(){
			_this.uploadImage(_this.buildSocio);
		});
		_this.bindFileSelectorEvent();
		_this.addValidations();
	}

	this.bindFileSelectorEvent = function(){
		$("#imgFile").on("change",function(e){
			$("#picBox").empty();
    		for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        
		        var file = e.originalEvent.srcElement.files[i];
		        
		        var reader = new FileReader();
		        reader.onloadend = function() {
		        	if(validateFileSize(document.getElementById("imgFile"),5000000)){
		             var html = "<img id='imgPreview' style='max-height:250px;width:200px;border:6px dashed #666' src=" + reader.result + " />";
		             $("#picBox").append(html);
		         }else{
		         	showMsg("El tamaño de la imagen sobrepasa el limite que son 5 megas");
					$("#imgPreview").remove();
		         }
		        }
		        reader.readAsDataURL(file);
		    }

		});
	}

	this.addValidations = function(){
		$("#txtNombre").attr("regex",new commonRegex().name);
		$("#txtApellidoP").attr("regex",new commonRegex().name);
		$("#txtApellidoM").attr("regex",new commonRegex().stringOptional);
		$("#txtEmail").attr("regex",new commonRegex().email);
	}

	this.validateData = function(){
		var validData = validateFields("tablaInscripciones","field");

		if(parseInt($("#selectCategoria").val())<1){
			validData = false;
			appendError($("#selectCategoria"),"Es necesario seleccionar una categoria");
			$("#selectCategoria").css("background-color","#F0DA95");
		}else{
			removeError($("#selectCategoria"));
			$("#selectCategoria").css("background-color","#F4F4F4");
		}
		$(".firstFocus").focus();
		return validData;
	}

	this.buildSocio = function(){
				var date = getCurrentUTCDate();
				if(_this.currentImgName.length < 1){
					var dateObj = new Date();

					_this.currentImgName = "pic"+dateObj.getUTCMonth()+"-"+dateObj.getUTCDate()+
												"-"+dateObj.getUTCFullYear()+"_"+dateObj.getUTCHours()+
												dateObj.getUTCMinutes()+dateObj.getUTCSeconds()+".jpg";
				}
				var newInscripcion = { 
					inscripcion:{
						nombre: $("#txtNombre").val(),
						apellidop: $("#txtApellidoP").val(),
						apellidom: $("#txtApellidoM").val(),
						email: $("#txtEmail").val(),
						idcategoria: $("#selectCategoria").val(),
						imgname: _this.currentImgName,
						comentario:  $("#txtComentario").val()
					}
				}

				var ajaxConfiguration = {
					data:newInscripcion,
					URL:"addInscripcion",
					callBack:_this.afterSave,
					async:true,
					showLoading:true
				}

				new AjaxRequest().request(ajaxConfiguration);
	}

	this.afterSave = function(response){
		_this.clearForm();
		if(response>0){
			showMsg("Socio registrado!");
		}else{
			showMsg("El socio no pudo ser registrado!");
		}
	}

	this.clearForm = function(){
		$(".field").val("");
		$("#selectCategoria option[value=-1]").attr('selected', 'selected');
		$("#imgFile").replaceWith($("#imgFile").clone());
		$("#picBox").empty();
		_this.currentImgName = "";
		_this.bindFileSelectorEvent();
	}

	this.uploadImage = function(callBack){
			if(!_this.loadingImage){
				if(_this.validateData()){
					if($("#imgFile").val().length>0){
						_this.loadingImage = true;
							$("#imgFile").upload("php/uploadImage.php?test="+Math.random()*1000,
								function(response){
									_this.loadingImage = false;
									if(response.error==0){
										_this.currentImgName = response.newName;
										//$("#picBox").append("<img style='height:200px;width:250px;border:6px dashed #666' src=/php/sociosImg/"+response.newName+" />");
										callBack();
									}else{
										alert("Error: " + response.errorMsg);
									}
								},
								function(progress){
									$("#progressBar").progressbar({value:Math.round((progress.loaded/progress.total)*100)});
								}
							);
					}else{
						_this.currentImgName = "";
						callBack();
					}
				}
			}else{
				showMsg("Una imagen se esta cargando por favor espera");
		}
	}
}