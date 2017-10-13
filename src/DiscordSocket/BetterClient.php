<?php

namespace SimpleDiscord\DiscordSocket;

class BetterClient extends \WebSocket\Client {
	public function getSocket() {
		return $this->socket;
	}

	public function connectIfNotConnected() {
		if (!$this->is_connected) $this->connect();
	}
}
