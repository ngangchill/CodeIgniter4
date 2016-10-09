<?php namespace App\Controllers;

use CodeIgniter\Controller;
use \CodeIgniter\CLI\CLI;

class Tools extends Controller
{
	public function message()
	{
		$color = CLI::prompt('What is your favorite color?');
	}

	//--------------------------------------------------------------------

}
