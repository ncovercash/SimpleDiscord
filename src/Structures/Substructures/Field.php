<?php

namespace SimpleDiscord\Structures\Substructures;

class Field {
	public $data=null;
	public $confidence=0;

	public function __construct($data=null, int $confidence=0) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data=null) {
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function setConfidence($confidence=0) {
		$this->confidence = $confidence;
	}

	public function getData() {
		return $this->data;
	}

	public function getConfidence() : int {
		return $this->confidence;
	}
}
