<?php 
namespace Model;
class CommentsModel
{
	public static function find($link_id)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM comments WHERE link_id = ?");
		
		$stmt->execute([$link_id]);
		
		$row = $stmt->fetchAll();
		return $row;
	}
	public static function insert($link_id, $content)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO comments (link_id, content) VALUES (?, ?)");
		$stmt->execute([$link_id, $content]);
		$stmt = null;//Bas kardo yaar ;)
	}
}