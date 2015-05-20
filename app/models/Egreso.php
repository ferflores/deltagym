<?php
	class Egreso extends Eloquent {
		public $timestamps = false;
		
		protected $fillable = array('monto','fecha','idtipodeegreso');

		protected $table = 'egresos';

	}
?>