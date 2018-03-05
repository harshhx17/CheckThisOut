<?php 
require '../vendor/autoload.php';
Toro::serve(array(
	"/" => "\Controller\Homecontroller",
	"/link/:number" => "\Controller\LinkController"
));
