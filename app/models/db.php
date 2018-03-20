<?php 
class DB
{
	public static $instance;
	public static function get_instance()
	{
		$username = '';
		$password = '';
		if(!self::$instance)
		{
			    self::$instance = new PDO("mysql:host=localhost;dbname=mvc", "$username", "$password");
    			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}
}