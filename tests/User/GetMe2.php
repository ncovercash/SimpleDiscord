<?php

// will print the authenticated user

require_once "autoload.php";

$discord = new \SimpleDiscord\SimpleDiscord([
	"token" => file_get_contents("tests/token.txt"),
	"debug" => 3
]);

$discord->registerHandler("READY", function($data, \SimpleDiscord\SimpleDiscord $discord) {
	echo $discord->getUser()."\n";
	$discord->quit();
});

$discord->run();
