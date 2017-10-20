<?php

namespace SimpleDiscord\Structures\Guild;

class Role extends \SimpleDiscord\Structures\Substructures\Substructure {
	protected $data;
	protected $discord;

	public function __construct(
		// we have no way of querying a role without guild info, which we aint got
		string $id,
		string $name,
		int $color,
		bool $hoist,
		int $position,
		int $permissions,
		bool $managed,
		bool $mentionable
		\SimpleDiscord\SimpleDiscord $discord
	) {
		$this->discord = $discord;

		// no fields, all concrete
		$this->data = (object)([
			"id" => $id,
			"name" => $name,
			"color" => $color,
			"hoist" => $hoist,
			"poisition" => $position,
			"permissions" => $permissions,
			"managed" => $managed,
			"mentionable" => $mentionable
		]);
	}

	public function __get(string $name) {
		if (isset($this->data->$name)) {
			return $this->data->$name;
		} else {
			throw new \InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
		}
	}

	public function __set(string $name, $value) {
		if (isset($this->data->$name)) {
			$this->data->$name = $value;
		} else {
			throw new \InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
		}
	}

	public function __isset(string $name) : bool {
		return isset($this->data->$name);
	}

	public function __toString() : string {
		return implode("\n", [
			"User object:",
			"  ID: ".$this->id,
			"  Username: ".$this->username,
			"  Discriminator: ".$this->discriminator,
			"  Avatar: ".$this->avatar,
			"  Bot: ".($this->bot ? "true" : "false"),
			"  MFA Enabled: ".($this->mfaEnabled ? "true" : "false"),
			"  Verified Email: ".($this->verified ? "true" : "false"),
			"  Email: ".($this->email ? $this->email : "Unknown/null")
		]);
	}
}
