<?php 
namespace Controller;
class Homecontroller
{
	public function get(){
		session_start();
		if($_SESSION['id'])
			header('Location: /profile');
		echo \View\Loader::make()->render('templates/home.twig',
		array('links' => $links));

	}
	public function post(){
		session_start();
		if($_SESSION['id'])
			header('Location: /profile');
		$title = $_POST['title'];
		$url = $_POST['url'];
		$username = $_POST['username'];

		\Model\LinkModel::insert($title, $url, $username);

		$links = \Model\LinkModel::all();

		echo \View\Loader::make()->render('templates/home.twig',
		array('links' => $links));
	}

}
