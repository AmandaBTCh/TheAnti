<?php

namespace TheAnti\HandStrength;

use TheAnti\GameElement\Card;
use TheAnti\GameElement\Board;
use TheAnti\GameElement\Hand;
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

	//@var Board The board.
	protected $board = NULL;

	//@var Range The range to calculate strength for.
	protected $range = NULL;

	//@var array Mapping of hands to equities.
	protected $handEquities = [];

	//@var bool Indicates whether we're in a calculated state or not.
	protected $calculated = false;

	/*
	 * Creates a new hand strength calculator based on an optional board.
	 * Accepts an array of Card objects.
	 */
	public function __construct(Board $board, Range $range)
	{
		$this->setRange($range);

		$this->board = $board;
	}

	/*
	 * Sets/overwrites the range we're working with.
	 * Destroys the array of calculated equities
	 */
	public function setRange(Range $range)
	{
		$this->range = $range;
		$this->clearCalculation();
	}

	/*
	 * Calculates equities for all hands in range.
	 */
	public function calculate(): bool
	{
		$this->clearCalculation();

		//Generate file for hands in our range
		$rangeContents = "";
		foreach($this->range->getHands() as $hand)
		{
			$rangeContents .= $hand->toString() . "\n";
		}
		file_put_contents($this->rangeFolder . "\\range_hands.txt", chop($rangeContents));

		//Build board string
		$board = "";
		foreach($this->board->getCards() as $card)
		{
			$board .= $card->toString();
		}

		$url = "http://localhost/poker/TheAnti/tool/generate_equities.php?omp={$this->ompEval}&handFile={$this->rangeFolder}\\range_hands.txt&board={$board}";

		$equities = file_get_contents($url);

		if($equities)
		{
			$lines = explode("\n", $equities);
			foreach($lines as $line)
			{
				$handEq = explode(": ", $line);
				$this->handEquities[$handEq[0]] = (float) $handEq[1];
			}

			$this->rankHandStrength();

			return $this->calculated = true;
		}

		else
		{
			return false;
		}
	}

	/*
	 * Indicates whether we can get already calculated equities.
	 */
	public function isCalculated(): bool
	{
		return $this->calculated;
	}

	/*
	 * Gets the array of calculated equities for each hand in range.
	 */
	public function getRangeStrength(): array
	{
		return $this->handEquities;
	}

	/*
	 * Gets the strength of a hand based on its position in the array of equities.
	 * This just tells you the offset divided by the total, which is a bit too
	 * simple as many hands will have very similar equities.
	 * @return float A number between 0 and 1
	 * The closer to 1 the stronger the hand as it's basically a percent indicating
	 * how strong our hand is.
	 * A negative indicates that the hand was not in our range.
	 * Should this be an exception?
	 */
	public function getHandStrength(Hand $hand): float
	{
		$handString = $hand->toString();
		if(!isset($this->handEquities[$handString]))
		{
			return -3.14;
		}

		else
		{
			$len = count($this->handEquities);
			$offset = array_search($handString, array_keys($this->handEquities));

			return round($offset / $len, 2);
		}
	}

	/*
	 * Orders the array from low to high in hand strength based on equity.
	 */
	protected function rankHandStrength()
	{
		asort($this->handEquities);
	}

	/*
	 * Clears the array of calculated equities sets our calculated status to false.
	 */
	protected function clearCalculation()
	{
		$this->handEquities = [];
		$this->calculated = false;
	}
}