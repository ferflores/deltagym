function ListaEmpleados(){
	var _this = null;

	this.ini = function(){
		_this = this;
		_this.createTable();
	}

	this.createTable = function(){
		$('#jtableEmpleados').jtable({
            title: 'Empleados',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/listarEmpleados'
                /*createAction: '/GettingStarted/CreatePerson',
                updateAction: '/GettingStarted/UpdatePerson',
                deleteAction: '/GettingStarted/DeletePerson'*/
            },
            fields: {
                id: {
                	title:"Id",
                	width:"5%",
                    key: true,
                    display:function(data){
                    	return "0"+data.record.id;
                    },
                    //list: false
                },
                nombre: {
                    title: 'Nombre',
                    width: '15%'
                },
                apellidop: {
                    title: 'Apellido Paterno',
                    width: '15%'
                },
                apellidom: {
                    title: 'Apellido Materno',
                    width: '15%'
                    //type: 'date',
                    //create: false,
                    //edit: false
                },
                email: {
                    title: 'Email',
                    width: '15%',
                    sorting: true
                    //type: 'date',
                    //create: false,
                    //edit: false
                },
                created: {
                    title: 'Fecha de registro',
                    width: '15%',
                    display: function(data){
                        var date = new Date(data.record.created + " UTC");
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

        $('#jtableEmpleados').jtable('load');
	}
}