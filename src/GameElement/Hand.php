<?php

namespace TheAnti\GameElement;

/*
 * The object that represents a player's hand.
 */
class Hand
{
	//@var Card[] The cards in the hand.
	protected $cards = [];

	/*
	 * We accept an array of 2 cards
	 */
	public function __construct(array $cards)
	{
		if(count($cards) != 2)
		{
			throw new \Exception("Hands must have 2 cards!");
		}

		//Must all be Card objects
		else
		{
			foreach($cards as $card)
			{
				if(!($card instanceof Card))
				{
					throw new \Exception("Hands must consist of Card objects!");
				}
			}
		}

		/*
		 * We need to order these in some way for simplicity
		 * so that we treat AcKc and KcAc as the same hand.
		 * "Bigger" card comes first.
		 */
		$card1 = $cards[0]->getHash();
		$card2 = $cards[1]->getHash();
		if($card1 < $card2)
		{
			$cards = array_reverse($cards);
		}

		$this->cards = $cards;
	}

	/*
	 * Gets the array of cards.
	 */
	public function getCards(): array
	{
		return $this->cards;
	}

	/*
	 * Determines if a hand has a card.
	 * Used for finding invalid hands in ranges.
	 */
	public function hasCard(Card $card): bool
	{
		foreach($this->cards as $cardInHand)
		{
			if($card->toString() == $cardInHand->toString())
			{
				return true;
			}
		}

		return false;
	}

	/*
	 * Gets string representation of Hand.
	 */
	public function toString(): string
	{
		return $this->cards[0]->toString() . $this->cards[1]->toString();
	}

	/*
	 * Imports a hand from a string representation.
	 */
	public static function importFromString(string $hand): Hand
	{
		if(strlen($hand) != 4)
		{
			throw new \Exception("$hand is not a valid hand!");
		}

		//Get card strings
		$cardStrings = [
			substr($hand, 0, 2),
			substr($hand, 2, 2)
		];

		$cards = [];
		foreach($cardStrings as $cardString)
		{
			$cards[] = Card::importFromString($cardString);
		}

		return new Hand($cards);
	}
}