function Categorias(){
	
}

Categorias.fillSelect = function(selectId, data){
		$.each(data,function(i,e){
			$(selectId).append("<option value=" + e.id +">" + e.nombre + "</option>");
		});
	}