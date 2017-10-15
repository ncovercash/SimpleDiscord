<?php

namespace SimpleDiscord\Structures\Substructures;

class NullMayBeFalseField extends BoolField {
	public function __construct(?bool $data=false, int $confidence=-1) {
		if (is_null($data)) {
			$this->data = false;
			$this->confidence = 1;
		} else {
			$this->data = $data;
			$this->confidence = 2;
		}
		if ($confidence != -1) {
			$this->confidence = $confidence;
		}
	}

	public function setData($data=false) {
		if (!is_null($data) && !is_bool($data)) {
			throw new InvalidArgumentException("Invalid data passed to ".get_class());
		}
		if (is_null($data)) {
			$this->data = false;
		} else {
			$this->data = $data;
		}
		$this->confidence = 2;
	}
}
