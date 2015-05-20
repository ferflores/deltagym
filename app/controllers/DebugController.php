<?php

class DebugController extends BaseController {
	
	public function index()
	{
		/*$tipoDePago = TipoDePago::find(6);
		switch ($tipoDePago->id) {
			case 5:
				echo "jajaj";
				break;
			
			default:
				# code...
				break;
		}
		$pago = Pago::find(60);
		$date = new DateTime($pago->fecha);
		$date->add(new DateInterval('P30D'));
		$date2 = new DateTime();*/

		$password = Hash::make('d3lt4@020');

		var_dump($password);
	}

}

?>