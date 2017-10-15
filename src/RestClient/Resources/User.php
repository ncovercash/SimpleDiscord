<?php

namespace SimpleDiscord\RestClient\Resources;

class User extends BaseResource {
	public function getUser(string $id="@me") : \SimpleDiscord\Structures\User\User {
		$data = $this->client->sendRequest("users/".$id);

		$newObj = new \SimpleDiscord\Structures\User\User(
			$data->id,
			$data->username,
			$data->discriminator,
			$data->avatar,
			isset($data->bot) ? $data->bot : null,
			isset($data->mfaEnabled) ? $data->mfaEnabled : null,
			isset($data->verified) ? $data->verified : null,
			isset($data->email) ? $data->email : null,
			$this->client->discord
		);

		return $newObj;
	}

	public function getUserRaw(string $id="@me") : \stdClass {
		$data = $this->client->sendRequest("users/".$id);

		return $data;
	}

	public function setUsername(string $username) : \stdClass {
		$data = $this->client->sendRequest(
			"users/@me",
			[
				"http" => [
					"method" => "PATCH",
					"content" => json_encode([
						"username" => $username
					])
				]
			]
		);

		return $data;
	}

	public function setAvatar(string $file) : \stdClass {
		$data = $this->client->sendRequest(
			"users/@me",
			[
				"http" => [
					"method" => "PATCH",
					"content" => json_encode([
						"avatar" => 'data:image/'.pathinfo($file, PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents($file))
					])
				]
			]
		);

		return $data;
	}
}
