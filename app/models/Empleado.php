<?php
	class Empleado extends Eloquent {
		public $timestamps = false;
		
		protected $fillable = array('nombre','apellidop','apellidom','email','comentario','created','imgname');

		protected $table = 'empleados';

	}
?>