<?php 
class DB
{
	public static $instance;
	public static function get_instance()
	{
		if(!self::$instance)
		{
			    self::$instance = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}
}