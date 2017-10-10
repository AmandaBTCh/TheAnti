<?php

namespace TheAnti\GameElement;

class Deck
{
	//@var Card[]
	protected $cards = [];

	/*
	 * Creates a new deck.
	 */
	public function __construct()
	{
		$this->initDeck();
	}

	/*
	 * Initializes or resets a deck.
	 */
	public function initDeck()
	{
		$this->cards = [];

		foreach(Card::getRanks() as $rank)
		{
			foreach(Card::getSuits() as $suit)
			{
				$this->cards[] = new Card($rank, $suit);
			}
		}
	}

	public function shuffle()
	{
		shuffle($this->cards);
	}

	/*
	 * Gets a single card, giving an error if no cards are left,
	 * but this should never happen.
	 */
	public function getCard(): Card
	{
		return array_shift($this->cards);
	}

	/*
	 * Gets N number of cards.
	 * Would be faster to do an array_splice(cards, 0, num), but breaks OOP design
	 */
	public function getCards(int $num): array
	{
		$cards = [];

		while($num--)
		{
			$cards[] = $this->getCard();
		}

		return $cards;
	}
}