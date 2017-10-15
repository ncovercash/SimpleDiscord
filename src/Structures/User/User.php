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
		?string $avatar=null,
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

	private function setId(string $id) {
		$this->data->id->setData($id);
	}

	private function setUsername(?string $username) {
		$this->data->username->setData($username);
	}

	private function setDiscriminator(?string $discriminator) {
		$this->data->discriminator->setData($discriminator);
	}

	private function setAvatar(?string $avatar) {
		if (!is_null($avatar)) {
			$this->data->avatar->setConfidence(2);
		} else {
			// avatar is nullable...so we don't know if the client omitted or there is no avatar
			$this->data->avatar->setConfidence(1);
		}
		$this->data->avatar->setData(new \SimpleDiscord\Structures\User\Avatar($this->id, $this->discriminator, $avatar));
	}

	private function setBot(?bool $bot) {
		$this->data->bot->setData($bot);
	}

	private function setMfaEnabled(?bool $mfaEnabled) {
		$this->data->mfaEnabled->setData($mfaEnabled);
	}

	private function setVerified(?bool $verified) {
		$this->data->verified->setData($verified);
	}

	private function setEmail(?string $email) {
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

	private function getId() {
		return $this->data->id->getData();
	}

	private function getUsername() {
		if ($this->data->username->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->username->getData();
	}

	private function getDiscriminator() {
		if ($this->data->discriminator->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->discriminator->getData();
	}

	private function getAvatar() {
		if ($this->data->avatar->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->avatar->getData();
	}

	private function getBot() {
		if ($this->data->bot->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->bot->getData();
	}

	private function getMfaEnabled() {
		if ($this->data->mfaEnabled->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->mfaEnabled->getData();
	}

	private function getVerified() {
		if ($this->data->verified->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->verified->getData();
	}

	private function getEmail() {
		if ($this->data->email->getConfidence() != 2) {
			$this->populate();
		}
		return $this->data->email->getData();
	}

	public function __get(string $name) {
		switch ($name) {
			case "id":
				return $this->getId();
				break;
			case "username":
				return $this->getUsername();
				break;
			case "discriminator":
				return $this->getDiscriminator();
				break;
			case "avatar":
				return $this->getAvatar();
				break;
			case "bot":
				return $this->getBot();
				break;
			case "mfaEnabled":
				return $this->getMfaEnabled();
				break;
			case "verified":
				return $this->getVerified();
				break;
			case "email":
				return $this->getEmail();
				break;
			default:
				throw new InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
				break;
		}
	}

	public function __set(string $name, $value) {
		switch ($name) {
			case "id":
				$this->setId($value);
				break;
			case "username":
				$this->setUsername($value);
				break;
			case "discriminator":
				$this->setDiscriminator($value);
				break;
			case "avatar":
				$this->setAvatar($value);
				break;
			case "bot":
				$this->setBot($value);
				break;
			case "mfaEnabled":
				$this->setMfaEnabled($value);
				break;
			case "verified":
				$this->setVerified($value);
				break;
			case "email":
				$this->setEmail($value);
				break;
			default:
				throw new InvalidArgumentException("Property ".$name." of ".get_class()." does not exist.");
				break;
		}
	}

	public function __isset(string $name) : bool {
		return isset($this->data->$name);
	}

	public function freshen() {
		$this->populate();
	}
}
