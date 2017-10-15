<?php

namespace SimpleDiscord\Structures\Substructures;

class ConcreteStringField extends ConcreteField {
	public $data=null;

	public function __construct(string $data=null) {
		$this->data = $data;
	}

	public function setData(string $data) {
		$this->data = $data;
	}
}
