function ReporteGeneral(){
	_this = null;

	this.ini = function(){
		_this = this;
		_this.bindEvents();
	}

	this.bindEvents = function(){
		$('#minDate').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#maxDate').datepicker({ dateFormat: 'yy-mm-dd' });

		$(window).keydown(function(e) {
		    if (e.keyCode == 13) {
		        _this.getReport();
		    }
			});

		$("#getReport").on("click", function(){
			_this.getReport();
		});
	}

	this.getReport = function(){
		var minDate = $('#minDate').val();
		var maxDate = $('#maxDate').val();
		window.location.assign("reporteGeneral?minDate="+minDate+"&maxDate="+maxDate);
	}
}