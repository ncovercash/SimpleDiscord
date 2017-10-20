<?php

namespace SimpleDiscord\Structures\User;

class User implements \SimpleDiscord\Structures\Structure {
	protected $data;
	protected $discord;

	public function __construct(
		string $id,
		// we must have an ID - all other info can be gathered from the API
		// sure we _could_ make a way to find a user with username/discriminator but no
		?string $username=null,
		?string $discriminator=null,
		$avatar=null, // can be obj or string
		?bool $bot=null,
		?bool $mfaEnabled=null,
		?bool $verified=null,
		?string $email=null,
		\SimpleDiscord\SimpleDiscord $discord
	) {
		$this->discord = $discord;

		$this->data = (object)([
			"id" => new \SimpleDiscord\Structures\Substructures\ConcreteStringField(),
			"username" => new \SimpleDiscord\Structures\Substructures\StringField(),
			"discriminator" => new \SimpleDiscord\Structures\Substructures\StringField(),
			"avatar" => new \SimpleDiscord\Structures\Substructures\SubstructureField(),
			"bot" => new \SimpleDiscord\Structures\Substructures\NullMayBeFalseField(),
			"mfaEnabled" => new \SimpleDiscord\Structures\Substructures\NullMayBeFalseField(),
			"verified" => new \SimpleDiscord\Structures\Substructures\NullMayBeFalseField(),
			"email" => new \SimpleDiscord\Structures\Substructures\StringField()
		]);

		$this->id = $id;
		$this->username = $username;
		$this->discriminator = $discriminator;
		$this->avatar = $avatar;
		$this->bot = $bot;
		$this->mfaEnabled = $mfaEnabled;
		$this->verified = $verified;
		$this->email = $email;
	}

	private function internalGetId() {
		return $this->data->id->getData();
	}

	private function internalGetUsername() {
		if ($this->data->username->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->username->getData();
	}

	private function internalGetDiscriminator() {
		if ($this->data->discriminator->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->discriminator->getData();
	}

	private function internalGetAvatar() {
		if ($this->data->avatar->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->avatar->getData();
	}

	private function internalGetBot() {
		if ($this->data->bot->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->bot->getData();
	}

	private function internalGetMfaEnabled() {
		if ($this->data->mfaEnabled->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->mfaEnabled->getData();
	}

	private function internalGetVerified() {
		if ($this->data->verified->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->verified->getData();
	}

	private function internalGetEmail() {
		if ($this->data->email->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->email->getData();
	}

	private function internalSetId(string $id) {
		$this->data->id->setData($id);
	}

	private function internalSetUsername(?string $username) {
		$this->data->username->setData($username);
	}

	private function internalSetDiscriminator(?string $discriminator) {
		$this->data->discriminator->setData($discriminator);
	}

	private function internalSetAvatar(?string $avatar) {
		if (!is_null($avatar)) {
			$this->data->avatar->setConfidence(2);
		} else {
			// avatar is nullable...so we don't know if the client omitted or there is no avatar
			$this->data->avatar->setConfidence(1);
		}
		if (is_null($avatar) || is_string($avatar)) {
			$this->data->avatar->setData(new \SimpleDiscord\Structures\User\Avatar($this->internalGetId(), $this->internalGetDiscriminator(), $avatar));
		} else if ($avatar instanceof \SimpleDiscord\Structures\User\Avatar) {
			$this->data->avatar->setData($avatar);
		} else {
			throw new \InvalidArgumentException("Invalid avatar provided to ".get_class());
		}
	}

	private function internalSetBot(?bool $bot) {
		$this->data->bot->setData($bot);
	}

	private function internalSetMfaEnabled(?bool $mfaEnabled) {
		$this->data->mfaEnabled->setData($mfaEnabled);
	}

	private function internalSetVerified(?bool $verified) {
		$this->data->verified->setData($verified);
	}

	private function internalSetEmail(?string $email) {
		$this->data->email->setData($email);
	}

	private function populate() {
		$user = $this->discord->getRestClient()->user->getUserRaw($this->id);

		$this->id = $user->id;
		
		$this->username = $user->username;
		
		$this->discriminator = $user->discriminator;
		
		$this->avatar = $user->avatar;
		$this->data->avatar->setConfidence(2);

		$this->bot = isset($user->bot) ? $user->bot : null;
		$this->data->bot->setConfidence(2);
		
		$this->mfaEnabled = isset($user->mfaEnabled) ? $user->mfaEnabled : null;
		$this->data->mfaEnabled->setConfidence(2);
		
		$this->verified = isset($user->verified) ? $user->verified : null;
		$this->data->verified->setConfidence(2);
		
		$this->email = isset($user->email) ? $user->email : null;
		$this->data->email->setConfidence(2);
	}

	public function setUsername(string $username) {
		if ($this->id != $this->discord->getUser()->id) {
			throw new \UnexpectedValueException("You can only change your own username!");
			return;
		}
		if (strlen($username) < 2 || strlen($username) > 32) {
			throw new \UnexpectedValueException("Username must be between 2 and 32 characters in length");
			return;
		}

		$newInfo = $this->discord->getRestClient()->user->setUsername($username);

		$this->freshen();
	}

	public function setAvatar(string $file) {
		if ($this->id != $this->discord->getUser()->id) {
			throw new \UnexpectedValueException("You can only change your own username!");
			return;
		}

		$newInfo = $this->discord->getRestClient()->user->setAvatar($file);

		$this->freshen();
	}

	public function __get(string $name) {
		switch ($name) {
			case "id":
				return $this->internalGetId();
				break;
			case "username":
				return $this->internalGetUsername();
				break;
			case "discriminator":
				return $this->internalGetDiscriminator();
				break;
			case "avatar":
				return $this->internalGetAvatar();
				break;
			case "bot":
				return $this->internalGetBot();
				break;
			case "mfaEnabled":
				return $this->internalGetMfaEnabled();
				break;
			case "verified":
				return $this->internalGetVerified();
				break;
			case "email":
				return $this->internalGetEmail();
				break;
			default:
				throw new \InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
				break;
		}
	}

	public function __set(string $name, $value) {
		switch ($name) {
			case "id":
				$this->internalSetId($value);
				break;
			case "username":
				$this->internalSetUsername($value);
				break;
			case "discriminator":
				$this->internalSetDiscriminator($value);
				break;
			case "avatar":
				$this->internalSetAvatar($value);
				break;
			case "bot":
				$this->internalSetBot($value);
				break;
			case "mfaEnabled":
				$this->internalSetMfaEnabled($value);
				break;
			case "verified":
				$this->internalSetVerified($value);
				break;
			case "email":
				$this->internalSetEmail($value);
				break;
			default:
				throw new \InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
				break;
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

	public function freshen() {
		$this->populate();
	}
}
