<?php

class ServiciosController extends BaseController {
	
	public function pagarServicioView()
	{
			$servicios = Servicio::All();
			return View::make('servicios.pago',array('sectionText' => '- Pago de servicio',
				'servicios'=>$servicios));
	}

	public function pagarServicio(){	

		date_default_timezone_set("UTC");

		try{

			DB::transaction(function(){

				$data = Input::get("pago");

				$egreso = new Egreso();
				$egreso->monto = $data['monto'];
				$egreso->idtipodeegreso = 2; //1: pago de servicio
				$egreso->fecha = date("Y-m-d H:i:s", time());
				$egreso->save();

				$pagoServicio = new PagoServicio();
				$pagoServicio->idegreso = $egreso->id;
				$pagoServicio->idservicio = $data['idservicio'];
				$pagoServicio->comentario = $data['comentario'];

				$pagoServicio->save();

				try{

					$gymlog = new Gymlog();
					$gymlog->idevento = 5; //evento pago de servicio
					$gymlog->idusuario = Auth::user()->id;
					$gymlog->fecha = date("Y-m-d H:i:s", time());
					$servicio = Servicio::find($data['idservicio']);
					$gymlog->mensaje = "Pago realizado del servicio: ".$servicio->nombre.", monto: $".$data['monto'];
					$gymlog->save();

				}catch(Exception $e){
					Log::error($e->getMessage());
				}
			});

			return json_encode(1);

		}catch(Exception $e){
			Log::error($e->getMessage());
			return json_encode(-1);
		}

	}

}

?>