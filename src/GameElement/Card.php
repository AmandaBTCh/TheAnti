<?php

namespace TheAnti\GameElement;


class Card
{
	const TWO	= 2;
	const THREE	= 3;
	const FOUR	= 4;
	const FIVE	= 5;
	const SIX	= 6;
	const SEVEN	= 7;
	const EIGHT	= 8;
	const NINE	= 9;
	const TEN	= 10;
	const JACK	= 11;
	const QUEEN = 12;
	const KING	= 13;
	const ACE	= 14;

	const SPADES	= 0;
	const DIAMONDS	= 1;
	const CLUBS		= 2;
	const HEARTS	= 3;

	protected $rank;
	protected $suit;

	/*
	 * Creates a new card based on rank and suit.
	 */
	public function __construct(int $rank, int $suit)
	{
		if(!isset(self::rankMap()[$rank]))
		{
			throw new \Exception("$rank is an invalid rank!");
		}

		if(!isset(self::suitMap()[$suit]))
		{
			throw new \Exception("$suit is an invalid suit!");
		}

		$this->rank = $rank;
		$this->suit = $suit;
	}

	/*
	 * Converts the card to a string representation.
	 */
	public function toString(): string
	{
		return self::rankMap()[$this->rank] . self::suitMap()[$this->suit];
	}

	/*
	 * Gets a unique integer based on the card.
	 * Used for comparing two cards for ordering in hands.
	 */
	public function getHash(): int
	{
		return ($this->rank * 10) + $this->suit;
	}

	/*
	 * Creates a card from a string representation.
	 */
	public function importFromString(string $card): Card
	{
		if(strlen($card) != 2)
		{
			throw new \Exception("$card is not a valid card!");
		}

		$rank = array_flip(Card::rankMap())[$card[0]];
		$suit = array_flip(Card::suitMap())[$card[1]];

		return new Card($rank, $suit);
	}

	/*
	 * Gets the suit.
	 */
	public function getSuit(): int
	{
		return $this->suit;
	}

	/*
	 * Gets the rank.
	 */
	public function getRank(): int
	{
		return $this->rank;
	}

	public static function suitMap(): array
	{
		return [
			self::SPADES	=> 's',
			self::DIAMONDS	=> 'd',
			self::CLUBS		=> 'c',
			self::HEARTS	=> 'h'
		];
	}

	public static function rankMap(): array
	{
		return [
			self::TWO	=> '2',
			self::THREE	=> '3',
			self::FOUR	=> '4',
			self::FIVE	=> '5',
			self::SIX	=> '6',
			self::SEVEN	=> '7',
			self::EIGHT	=> '8',
			self::NINE	=> '9',
			self::TEN	=> 'T',
			self::JACK	=> 'J',
			self::QUEEN	=> 'Q',
			self::KING	=> 'K',
			self::ACE	=> 'A',
		];
	}
}