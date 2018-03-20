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
	public static function insert($link_id, $content, $uid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO comments (link_id, content, uid) VALUES (?, ?, ?)");
		$stmt->execute([$link_id, $content, $uid]);
		$stmt = null;//Bas kardo yaar ;)
	}
}