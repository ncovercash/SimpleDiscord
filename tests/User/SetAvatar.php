<?php

// will set the avatar to "avatar.gif"

require_once "autoload.php";

$discord = new \SimpleDiscord\SimpleDiscord([
	"token" => file_get_contents("tests/token.txt"),
	"debug" => 3
]);

$discord->registerHandler("READY", function($data, \SimpleDiscord\SimpleDiscord $discord) {
	echo $discord->getUser()."\n";
	echo "Setting avatar to \"avatar.gif\"\n";
	$discord->getUser()->setAvatar(__DIR__."/avatar.gif");
	echo $discord->getUser()."\n";
	$discord->quit();
});

$discord->run();
