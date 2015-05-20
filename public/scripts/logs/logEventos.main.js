function LogEventos(){
	_this = null;
	this.ini = function(){
		_this = this;
		_this.createTable();
	}

	this.createTable = function(){
		$('#jtableLogEventos').jtable({
            title: 'Operaciones',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/getLogEventos'
                /*createAction: '/GettingStarted/CreatePerson',
                updateAction: '/GettingStarted/UpdatePerson',
                deleteAction: '/GettingStarted/DeletePerson'*/
            },
            fields: {
                username: {
                	title:"Usuario",
                	width:"5%"
                },
                operacion: {
                    title: 'Operación',
                    width: '15%'
                },
                mensaje: {
                    title: 'Mensaje',
                    width: '15%'
                },
                fecha: {
                    title: 'Fecha',
                    width: '15%',
                    display: function(data){
                        var date = new Date(data.record.fecha + " UTC");
                        var dateSplit = date.toString().split(" ");
                        var dateString = dateSplit[0] + " " + dateSplit[1] + " " + dateSplit[2] + " " + dateSplit[3] + " " + dateSplit[4];
                        return dateString;
                    }
                    //type: 'date',
                    //create: false,
                    //edit: false
                }
            },

            recordsLoaded:function(event,data){

            }
        });

        $('#jtableLogEventos').jtable('load');
	}
}