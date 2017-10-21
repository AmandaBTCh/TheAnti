<?php


namespace TheAnti\BoardAnalysis\BoardTexture;
use TheAnti\GameElement\Card;

/*
 * Gets information about the total number of
 * straights possible on a given board.
 * This more or less lets you know how connected
 * a board is.
 */
class Straight extends BoardTexture
{
	//@var array Stores an ordered list of unique ranks
	protected $ranks = [];

	public function __construct(array $board)
	{
		parent::__construct($board);
		$this->analyzeStraights();
	}

	/*
	 * Prepares the array of ranks to be checked
	 * for combos of straights.
	 */
	public function analyzeStraights()
	{
		//Builds the ordered array of unique ranks
		foreach($this->board as $card)
		{
			$rank = $card->getRank();
			$this->ranks[$rank] = true;
		}

		$this->ranks = array_keys($this->ranks);
		sort($this->ranks);

		//If this array ends in an A, put the A at the front too
		if(end($this->ranks) == Card::ACE)
		{
			array_unshift($this->ranks, 1);
		}
	}

	/*
	 * Gets the number of uniquely ranked hand combos
	 * which can make straights on this board.
	 */
	public function getStraights(): int
	{
		//No straights are possible unless we have 3 cards
		if(count($this->board) < 3)
		{
			return 0;
		}

		//Build a list of the 3 card combos in order
		$threeCombos = [];
		for($i=0; $i<count($this->board) - 2; $i++)
		{
			$cards = [];
			for($j=0; $j<3; $j++)
			{
				$cards[] = $this->board[$i + $j];
			}
			$threeCombos[] = $cards;
		}


	}
}