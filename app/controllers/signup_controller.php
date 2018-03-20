<?php 
namespace Controller;
class SignupController
{
	function get()
	{
		echo \View\Loader::make()->render('templates\signup.twig',array());
	}
	function post()
	{
		session_start();
		// To add a redirect to the profile page directly ;)
		$username = $_POST['username'];
		$password = $_POST['password'];
		$result = \Model\UserModel::insert($username,$password);
		if($result === 1){
			$user = \Model\UserModel::get_id($username,$password);
			$_SESSION['id'] = $user['id'];
			header('Location: profile');
		}
		else if($result === 0){
		echo \View\Loader::make()->render('templates\signup.twig',array('message'=>"That username exists, Please try a new one ;)"));
		}
	}
}