<?php
	class Pago extends Eloquent {
		public $timestamps = false;
		protected $fillable = array('idsocio','idtipodepago','monto','fecha','idpromocion','activo');
		protected $table = 'pagos';

		public function calcularProximaFecha($tipoDePago, $fecha, $isEdit){

			$currentDate = new DateTime();

			if($fecha<=$currentDate && !$isEdit){
				$fecha = $currentDate->add(new DateInterval('P'.$tipoDePago->ndias.'D'));

			}else{
				$fecha->add(new DateInterval('P'.$tipoDePago->ndias.'D'));
			}
			return $fecha;
		}

		public function obtenerUltimoPagoPorSocio($idsocio){
			$pago = Pago::where('idsocio','=',$idsocio)->where('activo','!=','0')
						->orderBy('id','desc')->first();
			return $pago;
		}

	}
?>