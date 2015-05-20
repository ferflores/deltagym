<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

	}
/*
	protected function hasAccess($requiredRoles){

		$userRoles = UserRoles::where('iduser','=',Auth::user()->id)->get();

		$hasAccess = false;

		foreach ($requiredRoles as $requiredRole) {
			foreach ($userRoles as $userRole) {
				$role = Roles::find($userRole->idrole);
				if(!is_null($role)){
					$roleName = $role->nombre;
					if($roleName == $requiredRole){
						$hasAccess = true;
						break;
					}
				}
			}
		}

		return $hasAccess;
		
	}

	protected function noAccess(){
		return View::make('noAccess',array('sectionText' => '- Sin Acceso'));
	}*/
}