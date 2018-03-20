<?php 
namespace Controller;
class ProfileController
{
	function get()
	{
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$id = $_SESSION['id'];

		$links = \Model\LinkModel::all();
		$user = \Model\UserModel::find($id);
		echo \View\Loader::make()->render('templates\profile.twig',array('links'=> $links,'user' => $user));
	}
	function post()
	{
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$id = $_SESSION['id'];
		if(isset($_POST['logout'])){
			session_destroy();
			header('Location: login');
		}
		$user = \Model\UserModel::find($id);// Think of a way in which the one called in the get function can itself be used instead of making a query.
		$title = $_POST['title'];
		$url = $_POST['url'];
		$username = $user['username'];

		\Model\LinkModel::insert($title, $url, $username);

		$links = \Model\LinkModel::all();

		echo \View\Loader::make()->render('templates\profile.twig',
		array('links'=> $links,'user' => $user));
	}
}