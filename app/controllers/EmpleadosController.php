<?php

class EmpleadosController extends BaseController {
	
	public function agregarEmpleadoView()
	{
			return View::make('empleados.registro',array('sectionText' => '- Alta de empleado'));
	}

	public function pagarEmpleadoView()
	{
			return View::make('empleados.pago',array('sectionText' => '- Pago de empleado'));
	}

	public function addEmpleado()
	{
		date_default_timezone_set("UTC");
		$input = Input::get("empleado");
		$empleado = new Empleado($input);
		$empleado->created = date("Y-m-d H:i:s", time());
		$empleado->save();

		try{
			$gymlog = new Gymlog();
			$gymlog->idevento = 3; //evento alta empleado
			$gymlog->idusuario = Auth::user()->id;
			$gymlog->fecha = date("Y-m-d H:i:s", time());
			$gymlog->mensaje = "Alta de empleado: ".$empleado->id. " - ".$empleado->nombre." ".$empleado->apellidop;
			$gymlog->save();

		}catch(Exception $e){
			Log::error($e->getMessage());
		}

		return json_encode($empleado->id);
	}

	public function pagarEmpleado(){	

		date_default_timezone_set("UTC");

		try{

			DB::transaction(function(){

				$data = Input::get("pago");

				$egreso = new Egreso();
				$egreso->monto = $data['monto'];
				$egreso->idtipodeegreso = 1; //1: pago a empleado
				$egreso->fecha = date("Y-m-d H:i:s", time());
				$egreso->save();

				$pagoEmpleado = new PagoEmpleado();
				$pagoEmpleado->idegreso = $egreso->id;
				$pagoEmpleado->idempleado = $data['idempleado'];
				$pagoEmpleado->comentario = $data['comentario'];

				$pagoEmpleado->save();

				try{

					$gymlog = new Gymlog();
					$gymlog->idevento = 4; //evento pago de empleado
					$gymlog->idusuario = Auth::user()->id;
					$gymlog->fecha = date("Y-m-d H:i:s", time());
					$empleado = Empleado::find($data['idempleado']);
					$gymlog->mensaje = "Pago realizado al empleado: 0".$data['idempleado']." ("
										.$empleado->nombre." ".$empleado->apellidop.") con el monto: $"
										.$data['monto'];
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