<?php 
namespace Model;
class CommentsModel
{
	public static function check($uid, $cid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentvote WHERE uid=? and cid=? LIMIT 1");
		$stmt->execute([$uid, $cid]);
		$row = $stmt->fetch();
		return $row["vote"];
	}
	public static function usercomments($uid)//might want to specify the order(time or votes)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM comments WHERE uid = ?");
		
		$stmt->execute([$uid]);
		
		$rows = $stmt->fetchAll();
		return $rows;
	}
	public static function order_time($link_id)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM comments WHERE link_id = ? ORDER BY time");
		
		$stmt->execute([$link_id]);
		
		$row = $stmt->fetchAll();
		return $row;
	}
	public static function order_vote($link_id)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM comments WHERE link_id = ? ORDER BY vote DESC");
		
		$stmt->execute([$link_id]);
		
		$row = $stmt->fetchAll();
		return $row;
	}
	public static function insert($link_id, $content, $uid, $username)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("INSERT INTO comments (link_id, content, uid, username) VALUES (?, ?, ?, ?)");
		$stmt->execute([$link_id, $content, $uid, $username]);
		$stmt = null;//Bas kardo yaar ;)
	}
	public static function vote($uid, $cid, $vote, $userid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentvote WHERE uid=? and cid=? LIMIT 1");
		$stmt->execute([$uid, $cid]);
		$result = $stmt->fetch();
		if($result){
			if($result['vote'] === $vote)
			{
				$stmt0 = $db->prepare("DELETE FROM commentvote
					   WHERE uid=? and cid=? LIMIT 1");
				$stmt0->execute(["$uid","$cid"]);
				$stmt0 = null;
				if($vote == 1){
					UserModel::decrement_karma($userid);
				}
				else if($vote == -1){
					UserModel::increment_karma($userid);
				}
			}
			else
			{
				$stmt0 = $db->prepare("UPDATE commentvote
					   SET vote = ?
					   WHERE uid=? and cid=? LIMIT 1");
				$stmt0->execute(["$vote","$uid","$cid"]);
				$stmt0 = null;
				if($vote == 1){
					UserModel::increment_karma($userid);
					UserModel::increment_karma($userid);
				}
				else if($vote == -1){
					UserModel::decrement_karma($userid);
					UserModel::decrement_karma($userid);
				}
			}
		}
		else{
			$stmt1 = $db->prepare("INSERT INTO commentvote (uid, cid, vote) VALUES (?, ?, ?)");
			$stmt1->execute(["$uid", "$cid", "$vote"]);
			$stmt1 = null;
			if($vote == -1){
				UserModel::decrement_karma($userid);
			}
			else{
				UserModel::increment_karma($userid);
			}
		}
		$votecount = self::votecount($cid);
		$stmt2 = $db->prepare("UPDATE comments SET vote=? WHERE id=?");
		$stmt2->execute(["$votecount", "$cid"]);
		$stmt2 = null;
	}
	public static function votecount($cid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM commentvote WHERE cid=?");
		$stmt->execute(["$cid"]);
		$result = $stmt->fetchAll();
		$votecount =0;
		foreach ($result as $row) {
			$votecount += $row['vote'];
		}
		return $votecount;
	}
}