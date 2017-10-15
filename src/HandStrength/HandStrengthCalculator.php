<?php

namespace TheAnti\HandStrength;

use TheAnti\GameElement\Card;

/*
 * Calculates the hand strength of all hands.
 * Can be given an optional board with 3, 4, or 5 cards.
 * This is fast enough that we don't care about only calculating for ranges.
 */
class HandStrengthCalculator
{
	//@var string The path to the file with all hand combos.
	protected $handFile = "C:\\xampp\\htdocs\\poker\\TheAnti\\tool\\all_hands.txt";

	//@var string The name of the executable to calculate hand equities.
	protected $ompEval = "OMPEval.exe";

	//@var Card[] The board.
	protected $board = [];

	/*
	 * Creates a new hand strength calculator based on an optional board.
	 * Accepts an array of Card objects.
	 */
	public function __construct(array $board = [])
	{
		foreach($board as $card)
		{
			$this->addCard($card);
		}
	}

	/*
	 * Adds a card to the board and invalidates the calculated equities.
	 */
	public function addCard(Card $card)
	{
		$this->board[] = $card;

		if(count($this->board) > 5)
		{
			throw new \Exception("The board can only have up to 5 cards!");
		}
	}

	/*
	 * Calculates equities for all hands.
	 */
	public function calculate(): bool
	{
		$board = "";
		foreach($this->board as $card)
		{
			$board .= $card->toString();
		}

		$boardPrefix = $board ?: "pre";

		$status = -1;
		$url = "http://localhost/poker/TheAnti/tool/generate_equities.php?omp={$this->ompEval}&handFile={$this->handFile}&board={$board}";
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