function SocioPicture(){
	_this = null;
	this.configuration = null;
	this.loadingImage = false;
	this.currentImgName = "";
	var html = "";

	this.setConfiguration = function(configuration){
		_this = this;
		_this.configuration = configuration;
	}

	this.showSocio = function(){
		html = _this.buildHtml(_this.configuration);
		$("#"+_this.configuration.divReference).empty();
		$("#"+_this.configuration.divReference).append(html);
		$("#"+_this.configuration.divReference).dialog({
	        title:'Socio',
	        modal:true,
	        width:600,
	        height:600,
	        resizable:false,
	        buttons: {
	            Cerrar: function(){
	                $(this).dialog("close");
	            }
	        }
	    });
	    _this.bindEvents();
	    $("#progressBar").progressbar({value:0});
	}

	this.bindEvents = function(){
		$("#btnChangeImage").button();
		$("#btnChangeImage").on("click", function(){
			_this.uploadImage(_this.imageUpdated);
		});

		$("#imgFile").on("change",function(e){
			$("#picBox").empty();
    		for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        
		        var file = e.originalEvent.srcElement.files[i];
		        
		        var reader = new FileReader();
		        reader.onloadend = function() {
		        	if(validateFileSize(document.getElementById("imgFile"),5000000)){
		        	$("#picBox").attr("src",reader.result);
		         }else{
		         	showMsg("El tamaño de la imagen sobrepasa el limite que son 5 megas");
		         }
		        }
		        reader.readAsDataURL(file);
		    }

		});
	}

	this.imageUpdated = function(){
		showMsg("Imagen actualizada!");
	}

	this.buildHtml = function(configuration){
		html = "<div>";
		html += "<div style='text-align:center;padding-bottom:10px'> <span style='font-size:1.5rem; text-align:center; font-weight:bold'>" + configuration.nombre + " " + configuration.apellidoP + "</span></div>";
		html += "<div style='text-align:center'><img id='picBox' src='php/sociosImg/" + configuration.imgURL + "' style='width:300px;max-height:400;border:3px dashed #666' onerror='this.src=&quot;img/default/no-image.jpg&quot;'/></div>";
		html += "<div>";
		html += "<table style='margin-top:10px'>";
		html += "<tr>";
		html += "<td>Cambiar foto: </td>";
		html += "</tr>";
		html += "<tr>";
		html += "<td style='text-align:left'>";
		html += "<input type='file' id='imgFile' name='files' accept='image/*' />";
		html += "</td>";
		html += "</tr>";
		html += "<tr><td><div id='progressBar' style='height:15px'></div></td></tr>";
		html += "<tr style='padding-top:10px'>";
		html += "<td style='text-align:left'>";
		html += "<input style='margin-top:20px' type='button' id='btnChangeImage' value='Guardar nueva imagen' />";
		html += "</td>";
		html += "</tr>";
		html += "</table>";
		html += "</div>";

		html += "</div>";

		return html;
	}

	this.uploadImage = function(callBack){
			if(!_this.loadingImage){
				if($("#imgFile").val().length>0){
					_this.loadingImage = true;
						$("#imgFile").upload("php/uploadImage.php?currentImage="+_this.configuration.imgURL,
							function(response){
								_this.loadingImage = false;
								if(response.error==0){
									_this.currentImgName = response.newName;
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
			}else{
				showMsg("Una imagen se esta cargando por favor espera");
		}
	}
}