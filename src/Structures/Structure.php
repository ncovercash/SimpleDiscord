<?php

namespace SimpleDiscord\Structures;

interface Structure {
	public function __get(string $name);
	public function __set(string $name, $value);
	public function __isset(string $name) : bool;
	public function __toString() : string;
	public function freshen();
}
