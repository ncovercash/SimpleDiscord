<?php

namespace SimpleDiscord\Structures\Substructures;

abstract class Image {
	private $url;

	const BASE_URI = "https://cdn.discordapp.com/";

	public function allowedFormats() : array;
	public function getBaseUrl() : string;

	// will, by default, round up
	// and use the webp format if specified is invalid
	public function getURL(int $size=512, string $format="webp", bool $roundUp=true) : string {
		$requestedPower = log($size, 2);
		$requestedPower = $roundUp ? ceil($requestedPower) : floor($requestedPower);
		$requestedPower = min(11, max(4, $requestedPower));

		$requestedFormat = in_array($format, $this->allowedFormats()) ? $format : "webp";

		return $this->getBaseUrl.".".$requestedFormat."?size=".pow(2, $requestedPower);
	}
}
