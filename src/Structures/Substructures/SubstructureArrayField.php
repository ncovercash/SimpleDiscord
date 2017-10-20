<?php

namespace SimpleDiscord\Structures\Substructures;

class SubstructureArrayField extends Field {
	public function __construct(?array $data=null, int $confidence=0) {
		if (!is_null($data)) {
			foreach ($data as $item) {
				if (!$item instanceof \SimpleDiscord\Structures\Substructures\Substructure) {
					throw new \InvalidArgumentException("Invalid data passed to ".get_class());
				}
			}
		}
		$this->data = $data;
		$this->confidence = $confidence;
	}

	public function setData($data=null) {
		if (!is_null($data)) {
			foreach ($data as $item) {
				if (!$item instanceof \SimpleDiscord\Structures\Substructures\Substructure) {
					throw new \InvalidArgumentException("Invalid data passed to ".get_class());
				}
			}
		}
		$this->data = $data;
		if (is_null($data)) {
			$this->confidence = 0;
		} else {
			$this->confidence = 2;
		}
	}

	public function getData() : ?array {
		return $this->data;
	}
}
