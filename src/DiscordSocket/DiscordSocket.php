<?php

namespace SimpleDiscord\DiscordSocket;

class DiscordSocket {
	private static $gatewayURL = null;

	private $discord;
	private $socket;

	public function __construct(\SimpleDiscord\SimpleDiscord $discord) {
		$this->discord = $discord;

		if (self::$gatewayURL === null) {
			self::$gatewayURL = $this->discord->getRestClient()->gateway->getGateway();
			$this->discord->log("Getting Gateway URI: ".self::$gatewayURL, 3);
		} else {
			$this->discord->log("Gateway URI cached: ".self::$gatewayURL, 3);
		}

		$this->discord->log("Creating websocket", 2);

		$this->socket = new \SimpleDiscord\DiscordSocket\BetterClient(self::$gatewayURL, [
			"timeout" => 300
		]);

		$this->socket->connectIfNotConnected();

		$this->discord->log("Identifying to websocket", 3);
		
		var_dump(stream_get_meta_data($this->socket->getSocket()));

		$this->identify();

		$this->discord->log("Websocket initialized.  Listening", 1);

		$this->run();
	}

	public function identify() {
		$this->socket->send(
			json_encode([
				'op' => 2,
				'd' => [
					'token' => $this->discord->getSocket(),
					'properties' => [
						'$os' => 'CLI',
						'$browser' => \SimpleDiscord\SimpleDiscord::LONG_VERSION,
						'$device' => \SimpleDiscord\SimpleDiscord::LONG_VERSION
					],
					'compress' => true
				]
			])
		);
	}

	public function run() {
		while (true) {
			var_dump(stream_get_meta_data($this->socket->getSocket()));
			$this->parseResponse($this->socket->receive());
		}
	}

	public static function parseResponse(string $in) {
		if (substr($in, 0, 1) != "{") {
			$in = zlib_decode($in);
		}

		$response = json_decode($in);

		var_dump($response);

		return $response;
	}
}
