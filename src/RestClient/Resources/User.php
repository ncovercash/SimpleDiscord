<?php

namespace SimpleDiscord\RestClient\Resources;

class User extends BaseResource {
	public function getUser($id="@me") : \SimpleDiscord\Structures\User\User {
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

	public function getUserRaw($id="@me") : stdClass {
		$data = $this->client->sendRequest("users/".$id);

		return $data;
	}
}
