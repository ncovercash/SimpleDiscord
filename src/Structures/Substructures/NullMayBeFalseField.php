<?php

namespace SimpleDiscord\Structures\Substructures;

class NullMayBeFalseField extends BoolField {
	public function __construct(?bool $data=false, int $confidence=-1) {
		if (is_null($data)) {
			$this->data = false;
			$this->confidence = 1;
		} else {
			$this->data = $data;
			$this->confidence = $confidence;
		}
		if ($confidence != -1) {
			$this->confidence = $confidence;
		}
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
