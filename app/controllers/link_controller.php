<?php 

namespace Controller;
class LinkController
{
	function get($slug){
		$comments = \Model\CommentsModel::find($slug);
		$link = \Model\LinkModel::find($slug);
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments));
	}
	function post($slug){
		$comment = $_POST['comment'];
		\Model\CommentsModel::insert($slug, $comment);
		$comments = \Model\CommentsModel::find($slug);
		$link = \Model\LinkModel::find($slug);
		echo \View\Loader::make()->render('templates/link.twig',
		array('link' => $link, 'comments' => $comments));
	}
}