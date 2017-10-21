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
}