<?php

namespace SimpleDiscord\Structures\Channel;

class MessageType extends \SimpleDiscord\Structures\Substructures\Enum {
	public static function getKeyedArray() : array {
		return [
			0 => "DEFAULT",
			1 => "RECIPIENT_ADD",
			2 => "RECIPIENT_REMOVE",
			3 => "CALL",
			4 => "CHANNEL_NAME_CHANGE",
			5 => "CHANNEL_ICON_CHANGE",
			6 => "CHANNEL_PINNED_MESSAGE",
			7 => "GUILD_MEMBER_JOIN"
		];
	}
}
