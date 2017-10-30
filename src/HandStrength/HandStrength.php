<?php

namespace TheAnti\HandStrength;

use TheAnti\GameElement\Hand;

/*
 * Represents the strength of a specific hand.
 * All numbers represent percentages against ATC (any two cards).
 */
class HandStrength
{
	//@var Hand The hand.
	protected $hand = NULL;

	//@var float Win percentage
	protected $win = 0.0;

	//@var float Loss percentage
	protected $loss = 0.0;

	//@var float Tie percentage
	protected $tie = 0.0;

	/*
	 * Creates a new hand strength representation based
	 * on a hand, and the percentages available to us from
	 * the C++ evaluator.
	 */
	public function __construct(Hand $hand, int $wins, int $ties, int $total)
	{
		$this->hand = $hand;

		//Calculate percentages
		$this->win = $wins / $total;
		$this->tie = $ties / $total;
		$this->loss = (($total - $wins) - $ties) / $total;
	}

	/*
	 * Gets the hand.
	 */
	public function getHand(): Hand
	{
		return $this->hand;
	}

	/*
	 * Gets the win percentage.
	 */
	public function getWin(): float
	{
		return round($this->win, 3);
	}

	/*
	 * Gets the loss percentage.
	 */
	public function getLoss(): float
	{
		return round($this->loss, 3);
	}

	/*
	 * Gets the tie percentage.
	 */
	public function getTie(): float
	{
		return round($this->tie, 3);
	}
}