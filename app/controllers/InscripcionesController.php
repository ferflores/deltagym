<?php

class InscripcionesController extends BaseController {
	
	public function index()
	{
			$categorias = Categoria::all();

			return View::make('socios.inscripcion',array('sectionText' => '- Inscripcion',
				'categorias'=>$categorias
				));

	}

	public function addInscripcion()
	{
		date_default_timezone_set("UTC");
		$input = Input::get("inscripcion");
		$socio = new Socio($input);
		$socio->created = date("Y-m-d H:i:s", time());
		$socio->save();

		try{
			$gymlog = new Gymlog();
			$gymlog->idevento = 1; //evento inscripcion
			$gymlog->idusuario = Auth::user()->id;
			$gymlog->fecha = date("Y-m-d H:i:s", time());
			$gymlog->mensaje = "Inscripción de socio <a href='status?idsocio=".$socio->id."'> 0".$socio->id."</a>";
			$gymlog->save();

		}catch(Exception $e){
			Log::error($e->getMessage());
		}

		return json_encode($socio->id);
	}
}

?>