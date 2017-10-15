<?php

namespace TheAnti\HandStrength;

use TheAnti\GameElement\Card;
use TheAnti\Range\Range;

/*
 * Calculates the hand strength of all hands.
 * Can be given an optional board with 3, 4, or 5 cards.
 */
class HandStrengthCalculator
{
	//@var string The path to the folder to store range files.
	protected $rangeFolder = "C:\\xampp\\htdocs\\poker\\TheAnti\\tool\\ranges";

	//@var string The name of the executable to calculate hand equities.
	protected $ompEval = "OMPEval.exe";

	//@var Card[] The board.
	protected $board = [];

	//@var Range The range to calculate strength for.
	protected $range = NULL;

	/*
	 * Creates a new hand strength calculator based on an optional board.
	 * Accepts an array of Card objects.
	 */
	public function __construct(array $board = [], Range $range)
	{
		$this->range = $range;

		foreach($board as $card)
		{
			$this->addCardToBoard($card);
		}
	}

	/*
	 * Adds a card to the board and invalidates the calculated equities.
	 */
	public function addCardToBoard(Card $card)
	{
		$this->board[] = $card;

		if(count($this->board) > 5)
		{
			throw new \Exception("The board can only have up to 5 cards!");
		}
	}

	/*
	 * Calculates equities for all hands in range.
	 */
	public function calculate(): bool
	{
		//Generate file for hands in our range
		$rangeContents = "";
		foreach($this->range->getHands() as $hand)
		{
			$rangeContents .= $hand->toString() . "\n";
		}
		file_put_contents($this->rangeFolder . "\\range_hands.txt", chop($rangeContents));

		//Build board string
		$board = "";
		foreach($this->board as $card)
		{
			$board .= $card->toString();
		}

		$url = "http://localhost/poker/TheAnti/tool/generate_equities.php?omp={$this->ompEval}&handFile={$this->rangeFolder}\\range_hands.txt&board={$board}";

		$equities = file_get_contents($url);

		if($equities)
		{
			print $equities;
			return true;
		}

		else
		{
			return false;
		}
	}
}