<?php

namespace TheAnti\BoardAnalysis;

use TheAnti\GameElement\Board;
use TheAnti\BoardAnalysis\BoardTexture\Flush;
use TheAnti\BoardAnalysis\BoardTexture\Straight;
use TheAnti\BoardAnalysis\BoardTexture\Paired;

/*
 * Gets information about a board based on the following criteria:
 * 1. Flushes and flush draws
 * 2. Straights and straight draws
 * 3. Paired and unpaired boards
 *
 * Uses BoardTexture objects to compute the
 * various information.
 */
class BoardAnalyzer
{
	//@var Board The board.
	protected $board = NULL;

	/*
	 * Creates a new board analyzer with a board.
	 */
	public function __construct(Board $board)
	{
		$this->board = $board;
	}

	/*
	 * Gets info about flushes based on board texture.
	 */
	public function getFlushInfo(): Flush
	{
		return new Flush($this->board);
	}

	/*
	 * Gets info about straights based on board texture.
	 */
	public function getStraightInfo(): Straight
	{
		return new Straight($this->board);
	}

	/*
	 * Gets info about paired boards based on board texture.
	*/
	public function getPairedInfo(): Paired
	{
		return new Paired($this->board);
	}

	/*
	 * Gets the street.
	 */
	public function getStreet(): int
	{
		return $this->board->getStreet();
	}
}