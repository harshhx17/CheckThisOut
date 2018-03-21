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

		$links = \Model\LinkModel::userlinks($id);
		$comments = \Model\CommentsModel::usercomments($id);
		$user = \Model\UserModel::find($id);
		for ($counter=0; !empty($links["$counter"]) ; $counter++) { 
			$links["$counter"]["voted"] = \Model\LinkModel::check($id, $links["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates\profile.twig',array('links'=> $links,'user' => $user, 'comments' => $comments));
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
		if(isset($_POST['submit'])){
			$title = $_POST['title'];
			$url = $_POST['url'];
			$username = $user['username'];
			\Model\LinkModel::insert($title, $url, $id, $username);
		}

		$links = \Model\LinkModel::userlinks($id);
		$comments = \Model\CommentsModel::usercomments($id);
		foreach ($links as $link) {
			$upname = "upvote" . "$link[id]";
			$downname = "downvote" . "$link[id]";
			if(isset($_POST["$upname"]))
			{
				\Model\LinkModel::vote($link['uid'], $link['id'], '1', $link['uid']);
			}
			else if(isset($_POST["$downname"]))
			{
				\Model\LinkModel::vote($link['uid'], $link['id'], '-1', $link['uid']);
			}
		}
		$links = \Model\LinkModel::userlinks($id);
		$comments = \Model\CommentsModel::usercomments($id);
		for ($counter=0; !empty($links["$counter"]) ; $counter++) { 
			$links["$counter"]["voted"] = \Model\LinkModel::check($id, $links["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates\profile.twig',
		array('links'=> $links,'user' => $user, 'comments' => $comments));
	}
}