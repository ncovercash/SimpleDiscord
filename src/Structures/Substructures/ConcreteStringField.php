<?php

namespace SimpleDiscord\Structures\Substructures;

class ConcreteStringField extends ConcreteField {
	public $data=null;

	public function __construct(string $data=null) {
		$this->data = $data;
	}

	public function setData($data=null) {
		if (!is_string($data)) {
			throw new InvalidArgumentException("Invalid string passed to ".get_class());
		}
		$this->data = $data;
	}
}
