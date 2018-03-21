<?php 
namespace Controller;
class LoginController
{
	public function get()
	{
		session_start();
		if($_SESSION['id'])
			header('Location: /');
		echo \View\Loader::make()->render('templates/login.twig', array());
	}
	public function post()
	{
		session_start();
		if($_SESSION['id'])
			header('Location: /');
	 	$username = $_POST['username'];
	 	$password = $_POST['password'];
	 	$result = \Model\UserModel::get_id($username,$password);
	 	if(!$result){
	 		$message = "You seem to have forgotten your id or password.";
	 		echo \View\Loader::make()->render('templates/login.twig', array('message' => $message));
	 	}
	 	else
	 	{
	 		$_SESSION["id"] = $result['id'];
	 		header("Location: /");
	 	}
	}
}