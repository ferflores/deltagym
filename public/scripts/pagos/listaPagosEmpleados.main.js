function ListaPagosEmpleados(){
	_this = null;

	this.ini = function(){
		_this = this;
        _this.createTable();
	}

	this.createTable = function(response){
		$('#jtablePagos').jtable({
            title: 'Pagos a empleados',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/getPagosEmpleados'
            },
            fields: {
                id: {
                    title:"id",
                    width:"5%",
                    key: true
                },
                nombre: {
                	title:"Nombre",
                	width:"5%"
                },
                apellidop: {
                    title:"Apellido Paterno",
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