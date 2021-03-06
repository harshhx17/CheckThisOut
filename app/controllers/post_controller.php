<?php 
namespace Controller;
class PostController
{
	function get($type)
	{
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$id = $_SESSION['id'];
		if($type === "recent")
		{
			$links = \Model\LinkModel::recentlinks();
		}
		else if($type === "top")
		{
			$links = \Model\LinkModel::toplinks();
		}
		else if($type === "trending")
		{
			$links = \Model\LinkModel::trendinglinks();
		}
		for ($counter=0; !empty($links["$counter"]) ; $counter++) { 
			$links["$counter"]["voted"] = \Model\LinkModel::check($id, $links["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates\post.twig',array('links'=> $links));
	}
	function post($type)
	{
		session_start();
		if(!$_SESSION['id'])
			header('Location: /login');
		$id = $_SESSION['id'];
		if($type === "recent"){
			$links = \Model\LinkModel::recentlinks();
		}
		else if($type === "top")
		{
			$links = \Model\LinkModel::toplinks();
		}
		else if($type === "trending")
		{
			$links = \Model\LinkModel::trendinglinks();
		}
		foreach ($links as $link)
		{
			$upname = "upvote" . "$link[id]";
			$downname = "downvote" . "$link[id]";
			if(isset($_POST["$upname"]))
			{
				\Model\LinkModel::vote($id, $link['id'], '1', $link['uid']);
			}
			else if(isset($_POST["$downname"]))
			{
				\Model\LinkModel::vote($id, $link['id'], '-1', $link['uid']);
			}
		}
		if($type === "recent"){
			$links = \Model\LinkModel::recentlinks();
		}
		else if($type === "top")
		{
			$links = \Model\LinkModel::toplinks();
		}
		else if($type === "trending")
		{
			$links = \Model\LinkModel::trendinglinks();
		}
		for ($counter=0; !empty($links["$counter"]) ; $counter++) { 
			$links["$counter"]["voted"] = \Model\LinkModel::check($id, $links["$counter"]['id']);
		}
		echo \View\Loader::make()->render('templates\post.twig',array('links'=> $links));

	}
}