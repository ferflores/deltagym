function BusquedaSocios(){
	var _this = null;
    var statusList = null;

	this.ini = function(statusList){
		_this = this;
        _this.statusList = statusList;
		_this.createTable();
        _this.bindEvents();
	}

    this.bindEvents = function(){
        $("#btnBuscar").on("click",function(){
            _this.buscarPorNombre();
        });

        $("#txtNombre").on("keydown",function(e){
            if(e.keyCode == 13){
                _this.buscarPorNombre();
            }
        });
    }

    this.buscarPorNombre = function(){
        $('#jtableSocios').jtable('load', { nombre: $("#txtNombre").val() });
    }

	this.createTable = function(){
		$('#jtableSocios').jtable({
            title: 'Socios',
            paging: true,
            pageSize: 15, 
            sorting: true,
            actions: {
                listAction: '/listarSocios',
                updateAction: '/updateSocio'
            },
            fields: {
                id: {
                	title:"Id",
                	width:"5%",
                    key: true,
                    display:function(data){
                    	return "0"+data.record.id;
                    },
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
                },
                categoria: {
                    title: 'Categoria',
                    width: '15%',
                    sorting: true,
                    edit: false
                },
                created: {
                    title: 'Fecha de ingreso',
                    width: '15%',
                    display: function(data){
                        var date = new Date(data.record.created + " UTC");
                        var dateSplit = date.toString().split(" ");
                        var dateString = dateSplit[0] + " " + dateSplit[1] + " " + dateSplit[2] + " " + dateSplit[3] + " " + dateSplit[4];
                        return dateString;
                    },
                    edit: false
                },
                preview: {
                    width: '2%',
                    sorting:false,
                    display: function(data){
                    	var imgId = "prev"+data.record.id;
                    	var html = "<img style='cursor:pointer;width:20px' class='prevSocio' id="+imgId+" src='img/icons/picicon.png' "
                        +"title='Ver foto'"
                        +"image='"+data.record.imgname+"'"
                        +"socioid='"+data.record.id+"'"
                        +"nombre='"+data.record.nombre+"'"
                        +"apellidop='"+data.record.apellidop+"'"
                        +"apellidom='"+data.record.apellidom+"'"
                        +"comentario='"+data.record.comentario+"'"
                        +" />";
                    	
                    	return html;
                    },
                    listClass:'updatePicture',
                    edit: false
                },

                verstatus: {
                    width: '2%',
                    sorting:false,
                    display: function(data){
                        var html = "<a href='status?idsocio=" + data.record.id + "'><img style='cursor:pointer;width:20px'"
                        +" title='Ver estatus'"
                        +" src='img/icons/description_icon.png'/></a>";
                        
                        return html;
                    },
                    edit: false
                },

                comentario: {
                    title:'Comentario',
                    width: '2%',
                    sorting:false,
                    visibility:'hidden'
                },

                idcategoria: {
                    title:'Categoria',
                    width: '2%',
                    sorting:false,
                    visibility:'hidden',
                    options: { '1': 'General', '2': 'Estudiante' }
                }
            },

            recordsLoaded:function(event,data){
            	$.each($(".prevSocio"),function(i,e){
            		     $(e).on("click",function(){
                            var socioConfig = {
                                divReference: "showPic",
                                nombre: $(e).attr("nombre"),
                                apellidoP: $(e).attr("apellidop"),
                                apellidoM: $(e).attr("apellidom"),
                                imgURL: $(e).attr("image"),
                                comentario: $(e).attr("comentario")
                            }
                            var socioPic = new SocioPicture();
                            socioPic.setConfiguration(socioConfig);
                            socioPic.showSocio();

            		});
            	});
                $(".jtable-edit-command-button").addClass("updateSocio");
                Main.removeDOMElementsByClasses();
            },
            recordUpdated:function(event,data){
                $.each($(".prevSocio"),function(i,e){
                         $(e).on("click",function(){
                            var socioConfig = {
                                divReference: "showPic",
                                nombre: $(e).attr("nombre"),
                                apellidoP: $(e).attr("apellidop"),
                                apellidoM: $(e).attr("apellidom"),
                                imgURL: $(e).attr("image"),
                                comentario: $(e).attr("comentario")
                            }
                            var socioPic = new SocioPicture();
                            socioPic.setConfiguration(socioConfig);
                            socioPic.showSocio();

                    });
                });
            }
        });

        $('#jtableSocios').jtable('load', { nombre : ""});
	}
}