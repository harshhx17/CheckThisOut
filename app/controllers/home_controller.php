<?php 
namespace Controller;
class Homecontroller
{
	public function get(){
		echo \View\Loader::make()->render('templates/home.twig');
	}
}
