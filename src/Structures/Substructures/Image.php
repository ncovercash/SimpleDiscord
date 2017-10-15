<?php

namespace SimpleDiscord\Structures\Substructures;

abstract class Image implements \SimpleDiscord\Structures\Substructures\Substructure {
	protected $url;

	const BASE_URI = "https://cdn.discordapp.com/";

	public abstract function allowedFormats() : array;

	public function getBaseURL() : string {
		return self::BASE_URI.$this->url;
	}

	// will, by default, round up
	// and use the png format if specified is invalid/nonexistent
	public function getURL(int $size=512, string $format="png", bool $roundUp=true) : string {
		$requestedPower = log($size, 2);
		$requestedPower = $roundUp ? ceil($requestedPower) : floor($requestedPower);
		$requestedPower = min(11, max(4, $requestedPower));

		$requestedFormat = in_array($format, $this->allowedFormats()) ? $format : "png";

		return $this->getBaseURL.".".$requestedFormat."?size=".pow(2, $requestedPower);
	}

	public function __toString() : string {
		return $this->getURL();
	}
}
