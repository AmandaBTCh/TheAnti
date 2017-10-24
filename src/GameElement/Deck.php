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

		foreach(array_keys(Card::rankMap()) as $rank)
		{
			foreach(array_keys(Card::suitMap()) as $suit)
			{
				$this->cards[] = new Card($rank, $suit);
			}
		}
	}

	/*
	 * Shuffles the deck.
	 */
	public function shuffle()
	{
		$cardsLen = count($this->cards);
		for($i=0; $i<$cardsLen; $i++)
		{
			$rand = mt_rand(0, $cardsLen - 1);
			$original = $this->cards[$i];

			//Swap the cards
			$this->cards[$i] = $this->cards[$rand];
			$this->cards[$rand] = $original;
		}
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