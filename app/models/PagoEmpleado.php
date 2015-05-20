<?php
	class PagoEmpleado extends Eloquent {
		public $timestamps = false;
		protected $fillable = array('idempleado','idegreso','comentario');
		protected $table = 'pagosempleados';
	}
?>