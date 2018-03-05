<?php 
require '../vendor/autoload.php';
class HelloHandler {
    function get() {
        echo "Hello, world";
    }
}
class Handler {
	function get() {
		echo "another route";
	}
}
Toro::serve(array(
    "/" => "HelloHandler",
    "/route" => "Handler"
));
?>