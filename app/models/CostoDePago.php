<?php
	class CostoDePago extends Eloquent {
		protected $table = 'costosdepago';

		public function getCategoria(){
			return $this->hasOne('Categoria','idcategoria');
		}

		public function getTipoDePago(){
			return $this->hasOne('TipoDePago','idtipodepago');
		}
	}
?>