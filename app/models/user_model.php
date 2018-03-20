<?php 
namespace Model;
class UserModel
{
	public static function get_id($username, $password)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT id FROM users WHERE username = ? and password = ? LIMIT 1");
		$stmt->execute([$username,$password]);
		$result = $stmt->fetch();
		return $result;
	}
	public static function find($id)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}
	public static function insert($username, $password)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT username FROM users WHERE username=? LIMIT 1");
		$stmt->execute([$username]);
		$result = $stmt->fetch();
		if($result){
			return 0;
		}
		$stmt1 = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
		$stmt1->execute([$username, $password]);
		$stmt1 = null;
		return 1;
	}
}