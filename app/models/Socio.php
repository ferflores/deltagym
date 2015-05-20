<?php
	class Socio extends Eloquent {
		public $timestamps = false;
		protected $fillable = array('nombre','apellidop','apellidom','email','imgname','created','comentario','idcategoria');
		protected $table = 'socios';

  		public function categoria(){
        	return $this->hasOne('categoria','idcategoria');
    	}

    	static function getStatus($idsocio){
    		$pago = new Pago();
			$ultimoPago = $pago->obtenerUltimoPagoPorSocio($idsocio);
			$currentDate = new DateTime();
			$status = '';

			if(!is_null($ultimoPago)){
				$proximoPago = new DateTime($ultimoPago->proximopago);
				if($currentDate <= $proximoPago && $currentDate >= $proximoPago->sub(new DateInterval('P3D'))){
					$status = 'ACTIVO PROXIMO A PAGAR';
				}else if($currentDate <= $proximoPago){
					$status = 'ACTIVO';
				
				}else if($currentDate->sub(new DateInterval('P2M')) > $proximoPago){
					$status = 'INACTIVO';
				}else{
					$status = 'SIN PAGAR';
				}
			}else{
				$status = 'SIN PAGOS REGISTRADOS';
			}

			return Status::where('estatus','=',$status)->first();
	    }

	    public function getValidator(){
	    	return Validator::make(
    			array(
    				'nombre' => $this->nombre,
    				'apellidop' => $this->apellidop,
    				'apellidom' => $this->apellidom,
    				'email' => $this->email,
    				'idcategoria' => $this->idcategoria,
    				'comentario' => $this->comentario
    				),
    			array(
    				'nombre' => array('regex:/^[áéíóúñA-Za-z\s]{3,20}$/','required'),
    				'apellidop' => array('regex:/^[áéíóúñA-Za-z\s]{3,20}$/','required'),
    				'apellidom' => array('regex:/^([áéíóúñA-Za-z\s]{3,30})?$/'),
    				'email' => 'email|max:50',
    				'idcategoria' => 'required|numeric|min:1',
    				'comentario' => array('regex:/^[áéíóúñA-Za-z0-9\s]{1,100}$/')
				));
	    }

	}
?>