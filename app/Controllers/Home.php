<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
	    session()->set("test",1123);

	    echo session()->get("test");
	}

	//--------------------------------------------------------------------

}
