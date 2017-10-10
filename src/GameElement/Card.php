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
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9',
			'T',
			'J',
			'Q',
			'K',
			'A'
		];
	}

	public static function getSuits(): array
	{
		return ['s', 'd', 'c', 'h'];
	}
}