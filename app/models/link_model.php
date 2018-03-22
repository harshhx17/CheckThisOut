<?php 
namespace Model;
class LinkModel
{
	public static function check($uid, $pid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM postvote WHERE uid=? and pid=? LIMIT 1");
		$stmt->execute([$uid, $pid]);
		$row = $stmt->fetch();
		return $row["vote"];
	}
	public static function trendinglinks()
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$links = [];
		$obj = new \DateTime();
		$time = $obj->getTimestamp();
		//gets current time
		$counter =0;
		foreach ($rows as $row) {
			$obj2 = new \DateTime($row["time"]);
			//gets the time of the row in same format as the time in $time
			$posttime = $obj2->getTimestamp();
			$timediff = $time-$posttime;
			if( $timediff < 2*24*60*60)
				// Taking the entries within 2 days from current time..
			{
				$links["$counter"] = $row;
				$links["$counter"]["rate"] = $row["vote"]/$timediff;
				$counter++;
				//making a rating on the basis of votes per unit time..
			}
		}
		//sorting the given links array on the basis of rate of each of its links
		foreach ($links as $key => $value) {
			$rate["$key"] = $value["rate"];
		}
		array_multisort($rate, SORT_DESC, $links);//sorts $links in the same way $rate has been sorted using the same keys...
		return $links;
	}
	public static function toplinks()
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links ORDER BY vote DESC");
		$stmt->execute();

		$rows = $stmt->fetchAll();

		return $rows;
	}
	public static function recentlinks()
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links ORDER BY time DESC");
		$stmt->execute();

		$rows = $stmt->fetchAll();

		return $rows;
	}
	public static function userlinks($uid)
	{
		$db = \DB::get_instance();

		$stmt = $db->prepare("SELECT * FROM links WHERE uid ='$uid'");
		$stmt->execute();

		$rows = $stmt->fetchAll();

		return $rows;
	}

	public static function insert($title, $url, $uid, $username)
	{
		$db = \DB::get_instance();
		//prepare statements prevents sqlinjection
		$stmt = $db->prepare("INSERT INTO links (title, url, uid, username) VALUES (?, ?, ?, ?)");
		$stmt->execute([$title, $url, $uid, $username]);
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
	public static function vote($uid, $pid, $vote, $userid)
	{
		//$uid has the user who is voting
		//$userid has the user who has posted the link
		//$pid has the id of the link
		//$vote has 1 or -1 depending on whether an upvote has to be processed or downvote
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM postvote WHERE uid=? and pid=? LIMIT 1");
		$stmt->execute([$uid, $pid]);
		$result = $stmt->fetch();
		if($result){
			if($result['vote'] === $vote)
			{
				$stmt0 = $db->prepare("DELETE FROM postvote
					   WHERE uid=? and pid=? LIMIT 1");
				$stmt0->execute(["$uid","$pid"]);
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
				$stmt0 = $db->prepare("UPDATE postvote
					   SET vote = ?
					   WHERE uid=? and pid=? LIMIT 1");
				$stmt0->execute(["$vote","$uid","$pid"]);
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
			$stmt1 = $db->prepare("INSERT INTO postvote (uid, pid, vote) VALUES (?, ?, ?)");
			$stmt1->execute(["$uid", "$pid", "$vote"]);
			$stmt1 = null;
			if($vote == -1){
				UserModel::decrement_karma($userid);
			}
			else{
				UserModel::increment_karma($userid);
			}
		}
		$votecount = self::votecount($pid);
		$stmt2 = $db->prepare("UPDATE links SET vote=? WHERE id=?");
		$stmt2->execute(["$votecount", "$pid"]);
		$stmt2 = null;
	}
	public static function votecount($pid)
	{
		$db = \DB::get_instance();
		$stmt = $db->prepare("SELECT * FROM postvote WHERE pid=?");
		$stmt->execute(["$pid"]);
		$result = $stmt->fetchAll();
		$votecount =0;
		foreach ($result as $row) {
			$votecount += $row['vote'];
		}
		return $votecount;
	}
}