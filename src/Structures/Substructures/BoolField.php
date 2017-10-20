<?php

namespace SimpleDiscord\Structures\Substructures;

class BoolField extends Field {
	public function __construct(?bool $data=null, int $confidence=0) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data=null) {
		if (!is_null($data) && !is_bool($data)) {
			throw new \InvalidArgumentException("Invalid data passed to ".get_class());
		}
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function getData() : ?bool {
		return $this->data;
	}
}
