function ListaPromos(){
	_this = null;

	this.ini = function(){
		_this = this;
        _this.createTable();
	}

	this.createTable = function(response){
		$('#jtablePromos').jtable({
            title: 'Promociones',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/getPromos',
                deleteAction: '/deletePromo',
                updateAction: '/updatePromo',
                createAction: '/createPromo',
            },
            fields: {
                id: {
                    title:"id",
                    width:"5%",
                    key: true,
                    visibility: 'hidden'
                },
                nombre: {
                	title:"nombre",
                	width:"10%"
                },
                costo: {
                    title: 'costo',
                    width: '15%'
                },
                idtipodepago: {
                    title: 'frecuencia de pago',
                    width: '15%'
                },
                solounavez: {
                    title: 'aplicar solo una vez (0= no, 1 = sí)',
                    width: '15%'
                }
            },

            recordsLoaded:function(event,data){

            }
        });

        $('#jtablePromos').jtable('load');
	}
}