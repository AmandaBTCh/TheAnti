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
 * 4. High: Rank of highest card using one of the following constants:
 * 		A. HIGH:		A-Q
 * 		B. MEDIUM_HIGH:	J-9
 * 		C. MEDIUM:		8-6
 * 		D. LOW:			5-2
 */
class HandAnalyzer
{
	//@var Hand The hand to analyze
	protected $hand = NULL;

	/*
	 * Hand height constants.
	 */

	//A-Q
	const HIGH = 14;
	//J-9
	const MEDIUM_HIGH= 11;
	//8-6
	const MEDIUM = 8;
	//5-2
	const LOW = 5;

	/*
	 * Cached values for performance.
	 */

	//@var bool Suited/unsuited
	protected $suited = NULL;

	//@var bool Paired/unpaired
	protected $paired = NULL;

	//@var int Height of hand
	protected $height = NULL;

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

	/*
	 * Determines whether the hand is paired.
	 */
	public function isPaired(): bool
	{
		if($this->paired === NULL)
		{
			$cards = $this->hand->getCards();
			$this->paired = ($cards[0]->getRank() == $cards[1]->getRank());
		}

		return $this->paired;
	}

	/*
	 * Gets the highest rank and converts it to one
	 * of the height constants based on the highest card
	 * in the hand.
	 */
	public function getHeight(): int
	{
		if($this->height === NULL)
		{
			$cards = $this->hand->getCards();
			$highRank = max($cards[0]->getRank(), $cards[1]->getRank());

			if($highRank > self::MEDIUM_HIGH)
			{
				$this->height = self::HIGH;
			}

			else if($highRank > self::MEDIUM)
			{
				$this->height = self::MEDIUM_HIGH;
			}

			else if($highRank > self::LOW)
			{
				$this->height = self::MEDIUM;
			}

			else
			{
				$this->height = self::LOW;
			}
		}

		return $this->height;
	}


}