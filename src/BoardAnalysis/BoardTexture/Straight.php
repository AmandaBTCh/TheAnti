<?php


namespace TheAnti\BoardAnalysis\BoardTexture;
use TheAnti\GameElement\Card;
use TheAnti\GameElement\Board;

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

	public function __construct(Board $board)
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
		foreach($this->board->getCards() as $card)
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
	 * Gets the number of uniquely ranked straights on a board.
	 */
	public function getStraights(): int
	{
		//No straights are possible unless we have 3 cards
		if(count($this->ranks) < 3)
		{
			return 0;
		}

		//Build a list of the 3 card combos in order
		$threeCombos = [];
		for($i=0; $i<count($this->ranks) - 2; $i++)
		{
			$cards = [];
			for($j=0; $j<3; $j++)
			{
				$cards[] = $this->ranks[$i + $j];
			}
			$threeCombos[] = $cards;
		}

		/*
		 * List of made straights where each straight
		 * is represented by a key with the small card
		 * and the value of the larger card.
		 * This automatically ensures we don't have duplicates.
		 */
		$straights = [];

		foreach($threeCombos as $threeCombo)
		{
			$madeStraights = $this->getComboStraights($threeCombo);
			foreach($madeStraights as $min => $max)
			{
				$straights[$min] = $max;
			}
		}

		return count($straights);
	}

	/*
	 * Accepts an array of 3 cards and gets an array
	 * of all possible straights where each straight
	 * is represented by a key with the min card and
	 * a value of the max card.
	 */
	protected function getComboStraights(array $cards): array
	{
		//Minimum and maximum cards in 3 card combo
		$max = $cards[2];
		$min = $cards[0];

		//Cards are too far apart, we can't make straights
		if($max - $min > 4)
		{
			return [];
		}

		//Get the top and bottom range of straights we can make
		$straightMax = $min + 4;
		$straightMin = $max - 4;

		//Make sure we're not above or below an Ace
		$straightMax = min(Card::ACE, $straightMax);
		$straightMin = max(1, $straightMin);

		$numStraights = ($straightMax - $straightMin) - 3;

		//Loop through the 5-card straights and add them to the return array
		$madeStraights = [];
		for($i=0; $i<$numStraights; $i++)
		{
			$madeStraights[$straightMin + $i] = $straightMin + $i + 4;
		}

		return $madeStraights;
	}
}