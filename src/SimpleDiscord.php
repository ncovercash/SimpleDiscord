<?php

namespace SimpleDiscord;

class SimpleDiscord {
	public const VERSION = "0.0.1";
	public const LONG_VERSION = 'SimpleDiscord/v'.self::VERSION.' SimpleDiscord (https://github.com/smileytechguy/SimpleDiscord, v'.self::VERSION.')';

	private $params;
	// token - token of the discord bot
	// debug - level from 0 (none) to 3 (most verbose) of debug information
	private $restClient;
	private $socket;

	public function __construct(array $params) {		
		if (!isset($params["token"])) {
			throw new \InvalidArgumentException("No token provided!  Token should be provided as a parameter with key \"token\".");
		}

		$params["debug"] = (isset($params["debug"]) &&
							$params["debug"] <= 3 && $params["debug"] >= 0)
							? $params["debug"]
							: 1;

		$this->params = (object)$params;

		$this->log("You are using ".self::LONG_VERSION, 1);

		$this->log("Initializing REST Client", 2);

		$this->restClient = new \SimpleDiscord\RestClient\RestClient([
			'Authorization' => 'Bot '.$this->params->token,
			'User-Agent' => self::LONG_VERSION
		]);
	}

	public function run() {
		$this->log("Creating websocket", 1);
		$this->socket = new \SimpleDiscord\DiscordSocket\DiscordSocket($this);
	}

	public function log(string $in, int $requiredLevel=1) {
		if ($this->params->debug >= $requiredLevel) {
			echo date('Y-m-d H:i:s')." ".$in."\n";
		}
	}

	public function getDebugLevel() : int {
		return $this->params->debug;
	}

	public function getToken() : string {
		return $this->params->token;
	}

	public function getSocket() : \SimpleDiscord\DiscordSocket\DiscordSocket {
		return $this->socket;
	}

	public function getRestClient() : \SimpleDiscord\RestClient\RestClient {
		return $this->restClient;
	}
}
