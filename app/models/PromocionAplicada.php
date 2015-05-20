<?php
	class PromocionAplicada extends Eloquent {
		public $timestamps = false;
		protected $fillable = array('idpago','idpromocion');
		protected $table = 'promocionesaplicadas';

	}
?>