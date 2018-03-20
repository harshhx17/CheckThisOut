<?php 
namespace Model;
class LinkModel
{
	public static function userlinks($uid)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links WHERE uid ='$uid'");
		$stmt->execute();

		$rows = $stmt->fetchAll();

		return $rows;
	}

	public static function insert($title, $url, $uid)
	{
		$db = \DB::get_instance();
		//prepare statements prevents sqlinjection
		$stmt = $db->prepare("INSERT INTO links (title, url, uid) VALUES (?, ?, ?)");
		$stmt->execute([$title, $url, $uid]);
		$stmt = null;//Bas kardo yaar ;)
	}
	public static function find($id)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links WHERE id = ?");
		
		$stmt->execute([$id]);
		
		$row = $stmt->fetch();
		return $row;
	}
}