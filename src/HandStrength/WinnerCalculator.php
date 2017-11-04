<?php

namespace TheAnti\HandStrength;

use TheAnti\GameElement\Hand;
use TheAnti\GameElement\Board;

/*
 * Takes two hands and a complete board and gets the winner.
 */
class WinnerCalculator
{
	//@var Hand hand1
	protected $hand1 = NULL;

	//@var Hand hand2
	protected $hand2 = NULL;

	//@var Board The board
	protected $board = NULL;

	//@var string The name of the executable to calculate the winner
	protected $ompEval = "OMPEval.exe";

	/*
	 * Creates a new winning hand calculator
	 */
	public function __construct(Hand $hand1, Hand $hand2, Board $board)
	{
		$this->hand1 = $hand1;
		$this->hand2 = $hand2;
		$this->board = $board;
		if(count($this->board->getCards()) != 5)
		{
			throw new \Exception("Cannot calculate the winner without a complete board.");
		}
	}

	/*
	 * Calculates the winner.
	 */
	public function calculate(): int
	{
		$board = $this->board->toString();
		return (int) file_get_contents("http://localhost/poker/TheAnti/tool/calculate_winner.php?omp={$this->ompEval}&hand1={$this->hand1->toString()}&hand2={$this->hand2->toString()}&board={$board}");
	}
}