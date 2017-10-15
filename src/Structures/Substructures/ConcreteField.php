<?php

namespace SimpleDiscord\Structures\Substructures;

class ConcreteField extends Field {
	public $data=null;
	public $confidence=2;

	public function __construct($data) {
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data) {
		$this->data = $data;
	}

	public function setConfidence($confidence=2) {
		throw new \LogicException("ConcreteFields do not have confidence - they are required to be absolute");
	}

	public function getConfidence() : int {
		throw new \LogicException("ConcreteFields do not have confidence - they are required to be absolute");
	}
}
