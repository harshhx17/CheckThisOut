<?php 

namespace Controller;
class LinkController
{
	function get($slug){
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$uid = $_SESSION['id'];
		$comments = \Model\CommentsModel::order_time($slug);
		$link = \Model\LinkModel::find($slug);
		$user = \Model\UserModel::find($uid);
		$username = $user['username'];
		for ($counter=0; !empty($comments["$counter"]) ; $counter++) { 
			$comments["$counter"]["voted"] = \Model\CommentsModel::check($uid,$comments["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments));
	}
	function post($slug){
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$uid = $_SESSION['id'];
		$link = \Model\LinkModel::find($slug);
		$user = \Model\UserModel::find($uid);
		$username = $user['username'];
		if(isset($_POST['submit']))
		{
			$comment = $_POST['comment'];
			\Model\CommentsModel::insert($slug, $comment, $uid, $username);
		}
		if(isset($_POST['vote'])){
			$comments = \Model\CommentsModel::order_vote($slug);
		}
		else
		{
			$comments = \Model\CommentsModel::order_time($slug);
		}
		foreach ($comments as $comment) {
			$upname = "upvote" . "$comment[id]";
			$downname = "downvote" . "$comment[id]";
			if(isset($_POST["$upname"]))
			{
				\Model\CommentsModel::vote($uid, $comment['id'], '1', $comment['uid']);
			}
			else if(isset($_POST["$downname"]))
			{
				\Model\CommentsModel::vote($uid, $comment['id'], '-1', $comment['uid']);
			}
		}
		if(isset($_POST['vote'])){
			$comments = \Model\CommentsModel::order_vote($slug);
		}
		else
		{
			$comments = \Model\CommentsModel::order_time($slug);
		}
		for ($counter=0; !empty($comments["$counter"]) ; $counter++) { 
			$comments["$counter"]["voted"] = \Model\CommentsModel::check($uid,$comments["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments));
	}
}