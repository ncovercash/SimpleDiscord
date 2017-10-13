<?php

namespace SimpleDiscord\DiscordSocket;

class DiscordSocket {
	private static $gatewayURL = null;

	private $discord;
	private $socket;

	private $lastHeartbeat,$heartbeatInterval=PHP_INT_MAX;

	private $lastFrame=null;

	private const CURRENT_GATEWAY_VERSION = "6";

	public function __construct(\SimpleDiscord\SimpleDiscord $discord) {
		$this->discord = $discord;

		if (self::$gatewayURL === null) {
			self::$gatewayURL = $this->discord->getRestClient()->gateway->getGateway();
			$this->discord->log("Getting Gateway URI: ".self::$gatewayURL, 3);
		} else {
			$this->discord->log("Gateway URI cached: ".self::$gatewayURL, 3);
		}

		$this->discord->log("Creating websocket", 2);

		$this->socket = new \SimpleDiscord\DiscordSocket\BetterClient(self::$gatewayURL."?v=".self::CURRENT_GATEWAY_VERSION."&encoding=json", [
			"timeout" => 300
		]);

		$this->socket->connectIfNotConnected();

		$this->discord->log("Identifying to websocket", 3);
		
		$this->identify();

		$this->discord->log("Websocket initialized.  Listening", 1);

		$this->run();
	}

	protected function identify() {
		$this->socket->send(
			json_encode([
				'op' => 2,
				'd' => [
					'token' => $this->discord->getToken(),
					'properties' => [
						'$os' => php_uname("s")." ".php_uname("r"),
						'$browser' => \SimpleDiscord\SimpleDiscord::LONG_VERSION,
						'$device' => \SimpleDiscord\SimpleDiscord::LONG_VERSION
					],
					'compress' => true
				]
			])
		);
	}

	public function run() {
		$this->parseResponse($this->socket->receive()); // initial
		$this->lastHeartbeat = microtime(true);
		while (true) {
			if (microtime(true)-$this->lastHeartbeat >= ($this->heartbeatInterval/1000) ||
				stream_get_meta_data($this->socket->getSocket())["timed_out"]) {
				stream_set_timeout($this->socket->getSocket(), (int)(($this->heartbeatInterval/1000)-microtime(true)+$this->lastHeartbeat-1));
				$this->sendHeartbeat();
			}
			// heartbeat "timer"
			stream_set_timeout($this->socket->getSocket(), (int)(($this->heartbeatInterval/1000)-microtime(true)+$this->lastHeartbeat-1));
			$this->parseResponse($this->socket->receive());
		}
	}

	protected function sendHeartbeat() {
		$this->lastHeartbeat = microtime(true);
		$this->discord->log("Sending hearbeat", 3);
		$this->socket->send(json_encode([
			"op" => 1,
			"d" => $this->lastFrame
		]));
	}

	public function parseResponse(string $in) {
		if ($in == "TIMED OUT") {
			return;
		}

		if ($in == "Rate limited.") {
			$this->discord->log("Rate limited", 1);
			return;
		}

		if (substr($in, 0, 1) != "{" && strlen($in) !== 0) {
			$in = zlib_decode($in);
		}

		$response = json_decode($in);

		if (!is_null($response)) {
			switch ($response->op) {
				case 0: // Dispatch
					$this->discord->log("Received gateway dispatch with name ".$response->t, 3);
					// $this->lastFrame = $response->s;
					break;
				case 1: // Heartbeat
					$this->discord->log("Heartbeat requested", 3);
					$this->sendHeartbeat();
					break;
				case 7: // Reconnect
					$this->discord->log("Reconnect requested", 2);
					break;
				case 9: // Invalid Session
					$this->discord->log("Invalid session provided", 2);
					$this->identify();
					break;
				case 10: // Hello
					$this->discord->log("Recieved hello", 3);
					$this->heartbeatInterval = $response->d->heartbeat_interval;
					$this->sendHeartbeat();
					break;
				case 11: // Heartbeat ACK
					$this->discord->log("Heartbeat acknowledged", 3);
					break;
				default:
					$this->discord->log("UNKNOWN GATEWAY OP CODE ".$response->op.".  Full event: ".$in, 0);
					break;
			}
		}

		return $response;
	}
}
