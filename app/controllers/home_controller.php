<?php 
namespace Controller;
class Homecontroller
{
	public function get(){
		$links = \Model\LinkModel::all();

		echo \View\Loader::make()->render('templates/home.twig',
		array('links' => $links));

	}
	public function post(){
		//create new model and save it in db
		
		$title = $_POST['title'];
		$url = $_POST['url'];
		$username = $_POST['username'];

		\Model\LinkModel::insert($title, $url, $username);

		$links = \Model\LinkModel::all();

		echo \View\Loader::make()->render('templates/home.twig',
		array('links' => $links));
	}

}
