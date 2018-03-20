<?php 
require '../vendor/autoload.php';
Toro::serve(array(
	"/" => "\Controller\ProfileController",
	"/link/:number" => "\Controller\LinkController",
	"/login" => "\Controller\LoginController",
	"/signup" => "\Controller\SignupController"
));
