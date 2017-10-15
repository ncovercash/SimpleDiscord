<?php

namespace SimpleDiscord\Structures\Substructures;

class NullableField extends Field {
	public function setData($data=null) {
		$this->data = $data;
		$this->confidence = 2;
	}
}
