<?php

namespace SimpleDiscord\Structures\Substructures;

abstract class Enum implements \SimpleDiscord\Structures\Substructures\Substructure {
	protected $value;

	public function __construct($value=0) {
		$this->setBaseValue($value);
	}

	public function getBaseValue() : int {
		return $this->value;
	}

	public function getValue() {
		if ($this->value == null) {
			return null;
		}
		return self::getKeyedArray()[$this->getBaseValue()];
	}

	public function setBaseValue($value) {
		if (!is_null($value) && !isset(self::getKeyedArray()[$this->getBaseValue()])) {
			throw new \InvalidArgumentException("Invalid value passed to ".get_class());
		}
		$this->value = $value;
	}

	public function setValue($newVal) {
		foreach (self::getKeyedArray() as $key => $value) {
			if ($newVal == $value) {
				$this->setBaseValue($key);
				return;
			}
		}
		throw new \InvalidArgumentException("Invalid value passed to ".get_class());
	}

	public static abstract function getKeyedArray() : array;

	public function __toString() : string {
		return $this->getValue();
	}
}
