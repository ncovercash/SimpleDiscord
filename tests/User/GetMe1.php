<?php

// will print the authenticated user

require_once "autoload.php";

$discord = new \SimpleDiscord\SimpleDiscord([
	"token" => file_get_contents("tests/token.txt"),
	"debug" => 3
]);

$client = $discord->getRestClient();

echo $client->user->getUser()."\n";
