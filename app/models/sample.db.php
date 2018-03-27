<?php 
class DB
{
	public static $instance;
	public static function get_instance()
	{
		$username = '';
		$password = '';
		$host = '';
		$dbname = '';
		if(!self::$instance)
		{
			    self::$instance = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
    			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}
}