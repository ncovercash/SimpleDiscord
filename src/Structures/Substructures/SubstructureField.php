<?php

namespace SimpleDiscord\Structures\Substructures;

class SubstructureField extends Field {
	public function __construct(?Substructure $data=null, int $confidence=0) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data=null) {
		if (!is_null($data) && !($data instanceof Substructure)) {
			throw new \InvalidArgumentException("Invalid data passed to ".get_class());
		}
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function getData() : ?Substructure {
		return $this->data;
	}
}
