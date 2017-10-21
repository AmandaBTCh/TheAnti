<?php

namespace TheAnti\HandAnalysis;

use TheAnti\GameElement\Hand;
use TheAnti\GameElement\Card;

/*
 * Gets information about a hand based on the
 * following criteria:
 * 1. Suited: Suited, Unsuited
 * 2. Paired: Paired, Unpaired
 * 3. Connected:
 * 		A. Number of straights we can flop (max = 49T, min = 0)
 * 		B. Distance between cards (max = 6, min = 0)
 * 4. High: Rank of highest card in hand (max = 13, min = 2)
 */
class HandAnalyzer
{
	//@var Hand The hand to analyze
	protected $hand = NULL;

	/*
	 * Cached values for performance.
	 */

	//@var boolean Suited/unsuited
	protected $suited = NULL;

	/*
	 * Creates a new hand analyzer based on a hand.
	 */
	public function __construct(Hand $hand)
	{
		$this->hand = $hand;
	}

	/*
	 * Determines whether the hand is suited.
	 */
	public function isSuited(): bool
	{
		if($this->suited === NULL)
		{
			$cards = $this->hand->getCards();
			$this->suited = ($cards[0]->getSuit() == $cards[1]->getSuit());
		}

		return $this->suited;
	}
}