<?php

namespace SimpleDiscord\Structures\Substructures;

class StringField extends Field {
	public function __construct(?string $data=null, int $confidence=0) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData(?string $data=null) {
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function getData() : ?string {
		return $this->data;
	}
}
