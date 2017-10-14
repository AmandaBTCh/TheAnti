<?php

namespace TheAnti\GameElement;


class Card
{
	protected $rank;
	protected $suit;

	public function __construct(string $rank, string $suit)
	{
		$this->rank = $rank;
		$this->suit = $suit;
	}

	public function toString(): string
	{
		return $this->rank . $this->suit;
	}

	public static function getRanks(): array
	{
		return [
			'A',
			'K',
			'Q',
			'J',
			'T',
			'9',
			'8',
			'7',
			'6',
			'5',
			'4',
			'3',
			'2',
		];
	}

	public static function getSuits(): array
	{
		return ['s', 'h', 'd', 'c'];
	}
}