<?php

namespace SimpleDiscord\Structures\Substructures;

class NullIsFalseField extends BoolField {
	public function __construct(?bool $data=false, int $confidence=0) {
		if (is_null($data)) {
			$this->data = false;
		} else {
			$this->data = $data;
		}
		$this->confidence = $confidence;
	}

	public function setData(?bool $data=false) {
		if (is_null($data)) {
			$this->data = false;
		} else {
			$this->data = $data;
		}
		$this->confidence = 2;
	}
}
