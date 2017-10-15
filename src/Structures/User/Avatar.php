<?php

namespace SimpleDiscord\Structures\User;

class Avatar extends \SimpleDiscord\Structures\Substructures\Image {
	protected $allowedFormats;

	public function __construct(string $id, string $discriminator, ?string $avatar) {
		if (is_null($avatar)) {
			$this->url = "embed/avatars/".($discriminator % 5);
			$this->allowedFormats = ["png"];
		} else {
			$this->url = "avatars/".$id."/".$avatar;
			$this->allowedFormats = ["png", "jpeg", "jpg", "webp", "gif"];
		}
	}

	public function allowedFormats() : array {
		return $this->allowedFormats;
	}
}
