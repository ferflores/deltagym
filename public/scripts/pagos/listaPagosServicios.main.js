function ListaPagosServicios(){
	_this = null;

	this.ini = function(){
		_this = this;
        _this.createTable();
	}

	this.createTable = function(response){
		$('#jtablePagos').jtable({
            title: 'Pagos de servicios',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/getPagosServicios'
            },
            fields: {
                id: {
                    title:"id",
                    width:"5%",
                    key: true
                },
                servicio: {
                	title:"Servicio",
                	width:"5%"
                },
                monto: {
                    title: 'Monto',
                    width: '15%',
                    display: function(data){
                        return '$'+data.record.monto;
                    }
                },
                fecha: {
                    title: 'Fecha',
                    width: '15%'
                },
                comentario: {
                    title: 'Comentario',
                    width: '15%'
                }
            },

            recordsLoaded:function(event,data){

            }
        });

        $('#jtablePagos').jtable('load');
	}
}