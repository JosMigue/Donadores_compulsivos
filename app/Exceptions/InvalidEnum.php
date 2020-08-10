<?php

namespace App\Exceptions;

use Exception;

class InvalidEnum extends Exception
{
 	public function render($request){
		return view('errors.500');
	}
}