<?php 
require '../vendor/autoload.php';
// error_reporting("-1");
// ini_set('display_errors',"On");
Toro::serve(array(
	"/" => "\Controller\ProfileController",
	"/link/:number" => "\Controller\LinkController",
	"/login" => "\Controller\LoginController",
	"/signup" => "\Controller\SignupController",
	"/posts/:string" => "\Controller\PostController"
));
