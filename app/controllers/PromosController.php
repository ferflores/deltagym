<?php

class PromosController extends BaseController {
	
	public function index()
	{

		return View::make('promos.list',array('sectionText' => '- Promociones'));
	}

	public function listarPromos(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');
		$offset = Config::get('configKeys.offsetHoursString');
		$sortBy = 'nombre';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}
		
		$query = "
			select * from promociones where activa = 1 order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('promociones')->count();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function deletePromo(){
		$result = new stdClass();

		try {
			$promo = Promocion::find(Input::get('id'));

			$promo->activa = 0;

			$promo->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 12; //promo borrada
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Promo borrada: ".$promo->nombre;
				$gymlog->save();

			}catch(Exception $e){
				Log::error($e->getMessage());
			}

			$result->Result = "OK";

		}catch(Exception $e){
					
			$result->Result = "Error";
			$result->Message = "Error: ".$e->getMessage();
		}

		return json_encode($result);
	}

	public function createPromo()
	{
		$result = new stdClass();

		try {
			$promo = new Promocion();

			$promo->nombre = Input::get("nombre");
			$promo->costo = Input::get("costo");
			$promo->idtipodepago = Input::get("idtipodepago");
			$promo->solounavez = 0;

			$promo->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 10; //promo agregada
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Promo agregada: ".$promo->nombre;
				$gymlog->save();

			}catch(Exception $e){
				Log::error($e->getMessage());
			}

			$result->Result = "OK";

		}catch(Exception $e){
					
			$result->Result = "Error";
			$result->Message = "Error: ".$e->getMessage();
		}

		return json_encode($promo);
	}


	public function updatePromo()
	{
		$result = new stdClass();

		try {
			$promo = Promocion::find(Input::get('id'));

			$promo->nombre = Input::get("nombre");
			$promo->costo = Input::get("costo");
			$promo->idtipodepago = Input::get("idtipodepago");
			$promo->solounavez = Input::get("solounavez");


			$promo->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 9; //promo modificada
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Promo modificado: ".$promo->nombre;
				$gymlog->save();

			}catch(Exception $e){
				Log::error($e->getMessage());
			}

			$result->Result = "OK";

		}catch(Exception $e){
					
			$result->Result = "Error";
			$result->Message = "Error: ".$e->getMessage();
		}

		return json_encode($result);
	}

	
}

?>