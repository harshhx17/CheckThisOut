<?php 

namespace Controller;
class LinkController
{
	function get($slug){
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$uid = $_SESSION['id'];
		$comments = \Model\CommentsModel::find($slug);
		$link = \Model\LinkModel::find($slug);
		$user = \Model\UserModel::find($uid);
		$username = $user['username'];
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments, 'username' => $username));
	}
	function post($slug){
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$comment = $_POST['comment'];
		$uid = $_SESSION['id'];
		\Model\CommentsModel::insert($slug, $comment, $uid);
		$comments = \Model\CommentsModel::find($slug);
		$link = \Model\LinkModel::find($slug);
		$user = \Model\UserModel::find($uid);
		$username = $user['username'];
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments, 'username' => $username));
	}
}