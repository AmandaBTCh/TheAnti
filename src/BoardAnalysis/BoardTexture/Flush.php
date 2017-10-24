<?php

namespace TheAnti\BoardAnalysis\BoardTexture;

use TheAnti\GameElement\Card;
use TheAnti\GameElement\Board;

/*
 * Gets information relating to flushes on a specific board.
 * The following information is provided:
 * 1. Number of flush draws (0, 1, or 2)
 * 2. Number of flushes (0 or 1)
 * 3. Number of cards needed to make a flush (-1, 0, 1, or 2)
 */
class Flush extends BoardTexture
{
	//@var array Suit analysis array.
	protected $suits = [
		Card::SPADES	=> 0,
		Card::DIAMONDS	=> 0,
		Card::CLUBS		=> 0,
		Card::HEARTS	=> 0
	];

	public function __construct(Board $board)
	{
		parent::__construct($board);
		$this->analyzeSuits();
	}

	/*
	 * Builds array of suits as follows:
	 * The index is the suit, and the value
	 * is the number of that suit on the board.
	 */
	protected function analyzeSuits()
	{
		foreach($this->board->getCards() as $card)
		{
			$this->suits[$card->getSuit()]++;
		}
	}

	/*
	 * Gets the number of flush draws possible on the board.
	 * On the river, this will always be zero.
	 */
	public function getFlushDraws(): int
	{
		if($this->isRiver())
		{
			return 0;
		}

		else
		{
			$draws = 0;
			foreach($this->suits as $num)
			{
				//2 and 3 to a flush means someone could have a draw
				if($num == 2 || $num == 3)
				{
					$draws++;
				}
			}
			return $draws;
		}
	}

	/*
	 * Gets the total number of flushes possible.
	 * This is either zero or one.
	 */
	public function getFlushes(): int
	{
		foreach($this->suits as $num)
		{
			if($num >= 3)
			{
				return 1;
			}
		}

		return 0;
	}

	/*
	 * Gets the number of cards required to make a flush.
	 * Will be either 0, 1, 2, or -1 if no flushes are possible.
	 */
	public function getCardsNeededForFlush(): int
	{
		//Maximum of any suit
		$suits = $this->suits;
		sort($suits);
		$max = array_pop($suits);

		//This is how many cards we need to make a flush
		$neededForFlush = 5 - $max;

		//If it's more than 2, no flushes are possible
		if($neededForFlush > 2)
		{
			return -1;
		}

		//We could have a flush!
		else
		{
			return $neededForFlush;
		}
	}
}