function ListaPagos(){
	_this = null;
    
    this.promociones = null;
    this.tiposDePago = null;

	this.ini = function(){
		_this = this;
        _this.createTable();
	}

	this.createTable = function(response){
		$('#jtablePagos').jtable({
            title: 'Pagos',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/getPagos',
                deleteAction: '/borrarPago',
                updateAction: '/updatePago'
            },
            fields: {
                id: {
                    title:"id",
                    width:"5%",
                    key: true
                    //visibility: 'hidden'
                },
                socio: {
                	title:"Socio",
                	width:"5%",
                    display: function(data){
                        var html = "<a href='status?idsocio="+data.record.socio+"'>"
                        +"0"+data.record.socio+"</a>";
                        return html;
                    },
                    edit: false
                },
                tipodepago: {
                    title: 'Tipo de pago',
                    width: '15%',
                    display:function(data){
                        return data.record.tipodepago;
                    },
                    edit:false
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
                    width: '15%',
                    display: function(data){
                        var date = new Date(data.record.fecha + " UTC");
                        var dateSplit = date.toString().split(" ");
                        var dateString = dateSplit[0] + " " + dateSplit[1] + " " + dateSplit[2] + " " + dateSplit[3] + " " + dateSplit[4];
                        return dateString;
                    },
                    edit: false
                },
                fechaWithOffset: {
                    title: 'Fecha',
                    width: '15%',
                    display: function(data){
                        return data.record.fechaWithOffset;
                    },
                    visibility: 'hidden'
                },
                proximopago: {
                    title: 'Próximo pago',
                    width: '15%',
                    type: 'date',
                    edit: false
                },
                promocion: {
                    title: 'Promoción',
                    width: '15%',
                    edit:false
                },

                idtipodepago: {
                    title: 'Tipo de pago',
                    width: '15%',
                    visibility:'hidden',
                    options: _this.tiposDePago
                },

                idpromocion: {
                    title: 'Promoción',
                    width: '15%',
                    visibility:'hidden',
                    options: _this.promociones
                }
            },

            recordsLoaded:function(event,data){

            }
        });

        $('#jtablePagos').jtable('load');
	}
}