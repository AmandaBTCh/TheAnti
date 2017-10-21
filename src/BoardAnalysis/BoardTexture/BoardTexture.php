<?php

namespace TheAnti\BoardAnalysis\BoardTexture;
/*
 * Base class for BoardTexture objects to provide some
 * basic functionality.
 * This isn't a true parent as the children cannot be
 * used in place of it nor can they be used in place
 * of one another.
 */
class BoardTexture
{
	//@var Card[] The board.
	protected $board = [];

	/*
	 * Sets the board for the board texture child to work with.
	 */
	public function __construct(array $board)
	{
		$this->board = $board;
	}

	/*
	 * Determines if this is on the flop.
	 */
	public function isFlop(): bool
	{
		return count($this->board) == 3;
	}

	/*
	 * Determines if this is on the turn.
	 */
	public function isTurn(): bool
	{
		return count($this->board) == 4;
	}

	/*
	 * Determines if this is on the flop.
	 */
	public function isRiver(): bool
	{
		return count($this->board) == 5;
	}
}