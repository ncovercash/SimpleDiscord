<?php

namespace SimpleDiscord\Structures\Substructures;

class StructureField extends Field {
	public function __construct(?\SimpleDiscord\Structures\Structure $data=null, int $confidence=0) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data=null) {
		if (!is_null($data) && !($data instanceof \SimpleDiscord\Structures\Structure)) {
			throw new \InvalidArgumentException("Invalid data passed to ".get_class());
		}
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function getData() : ?\SimpleDiscord\Structures\Structure {
		return $this->data;
	}
}
